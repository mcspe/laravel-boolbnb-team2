<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Braintree\Transaction;
use Braintree\Gateway;
use App\Models\Sponsorship;
use App\Models\Apartment;
use App\Models\ApartmentSponsorship;
use Illuminate\Support\Carbon;


class PaymentController extends Controller
{
  public function checkout(Request $request){
    try {

      $apartmentId = $request->input('apartmentId');
      $apartment = Apartment::where('id', $apartmentId)->first();

      $sponsorshipId = $request->input('sponsorshipId');
      $sponsorship = Sponsorship::where('id', $sponsorshipId)->first();

      // Crea un'istanza di Gateway con i parametri di configurazione
      $gateway = new Gateway([
        'environment' => config('services.braintree.environment'),
        'merchantId' => config('services.braintree.merchant_id'),
        'publicKey' => config('services.braintree.public_key'),
        'privateKey' => config('services.braintree.private_key'),
      ]);
      $nonce = $request->input('paymentMethodNonce');

      // Creo un cliente per autorizzare la verifica
      $customer = $gateway->customer()->create();
      $customerId = $customer->customer->id;
      // do {
      //   $customer = $gateway->customer()->find('testId');

      //   if (!$customer->success) {
      //     $newCustomer = $gateway->customer()->create([
      //       'id' => 'testId',
      //       // 'firstName' => Auth::user()->name,
      //       // 'lastName' => Auth::user()->lastname,
      //       // 'email' => Auth::user()->email
      //     ]);

      //     if (!$newCustomer->success) {
      //       $message = 'Problemi creazione cliente - Qualcosa è andato storto con il tuo pagamento. Siamo al lavoro per risolvere il problema. Ci scusiamo per il disagio.';
      //       $customer = 1; // forza l'uscita dal ciclo in caso di errore
      //     }
      //   }
      // } while ($customer === null);

      // Verifica del metodo di pagamento
      $cardVerification = $gateway->paymentMethod()->create([
        'customerId' => $customerId,
        'paymentMethodNonce' => $nonce,
        'options' => [
          'verifyCard' => true
        ]
      ]);

      $verificationSuccess = $cardVerification->success;

      // Controllo il succeso della verifica
      if ($verificationSuccess) {
        $paymentMethodToken = $cardVerification->paymentMethod->token;

        //Creo una transazione di vendita
        $saleTransaction = $gateway->transaction()->sale([
          'amount' =>  $sponsorship->price, // Importo della sponsorizzazione
          'paymentMethodToken' => $paymentMethodToken,
          'options' => [
            'submitForSettlement' => true
          ]
        ]);

        // Gestisco il risultato della transazione
        if ($saleTransaction->success) {

          $expiration_date = Carbon::now();
          switch ($sponsorshipId) {
            case '1':
              $expiration_date->addHours(24);
              break;
            case '2':
              $expiration_date->addHours(72);
              break;
            case '3':
              $expiration_date->addHours(144);
              break;
          }
          $payment_date = Carbon::now();

          /// aggiunta sponsorizzazione
          $sponsorship->apartments()->save($apartment, [
            'payment_date' => $payment_date,
            'expiration_date' => $expiration_date,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
          ]);

          $success = true;
          $message = 'Complimenti! Il tuo acquisto è andato a buon fine!';

        } else {
          $success = false;
          $message = "Purtroppo la transazione è stata negata. Ti consigliamo di contattare il tuo gestore per verificare il metodo di pagamento inserito.";
        }
      } else {
        $success = false;
        $message = "Purtroppo il metodo di pagamento da te inserito non può essere verificato. Ti consigliamo di contattare il tuo gestore per verificare quale potrebbe essere il problema.";
      }

      $response = response()->json(['success' => $success, 'message' => $message]);
      $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');

      return $response;

    } catch (\Exception $e) {
      // Cattura l'eccezione e loggala nel file di log
      Log::error($e->getMessage());

      // Ottieni il messaggio di errore dall'eccezione
      // $errorMessage = $e->getMessage();
      $errorMessage = "Qualcosa è andato storto con il tuo pagamento. Siamo al lavoro per risolvere il problema. Ci scusiamo per il disagio.";

      // Invia una risposta di errore al frontend
      return response()->json(['success' => false, 'message' => $errorMessage]);
    }
  }
}
