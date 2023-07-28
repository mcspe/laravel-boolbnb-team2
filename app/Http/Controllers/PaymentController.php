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
      $nonce = $request->input('paymentMethodNonce');

      $apartmentId = $request->input('apartmentId');
      $apartment = Apartment::where('id', $apartmentId)->first();

      $sponsorshipId = $request->input('sponsorshipId');
      $sponsorship = Sponsorship::where('id', $sponsorshipId)->first();

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

      // Crea un'istanza di Gateway con i parametri di configurazione
      $gateway = new Gateway([
        'environment' => config('services.braintree.environment'),
        'merchantId' => config('services.braintree.merchant_id'),
        'publicKey' => config('services.braintree.public_key'),
        'privateKey' => config('services.braintree.private_key'),
      ]);

      // Creo un cliente per autorizzare la verifica
        $newCustomer = $gateway->customer()->create([
          'id' => 'BnB_'.Auth::id(),
          'firstName' => Auth::user()->name,
          'lastName' => Auth::user()->lastname,
          'email' => Auth::user()->email
        ]);

      // Creo una transazione di vendita
      // $saleTransaction = $gateway->transaction()->sale([
      //   'amount' => $sponsorship->price, // Importo della sponsorizzazione
      //   'paymentMethodNonce' => $nonce,
      //   // 'customer' => [
      //   //   'id' => 'BnB_'.Auth::id(),
      //   //   'firstName' => Auth::user()->name,
      //   //   'lastName' => Auth::user()->lastname,
      //   //   'email' => Auth::user()->email,
      //   // ],
      //   'options' => [
      //     'submitForSettlement' => true,
      //     'storeInVaultOnSuccess' => true
      //   ]
      // ]);

      // Gestisco il risultato della transazione
      // if ($saleTransaction->success) {

        // Verifica del metodo di pagamento
        $cardVerification = $gateway->paymentMethod()->create([
          'customerId' => 'BnB_' . Auth::id(),
          'paymentMethodNonce' => $nonce,
          'options' => [
            'verifyCard' => true
          ]
        ]);

        $success = $cardVerification->success;

        // Controllo il succeso della verifica
        if ($success) {
          $message = $cardVerification;
        } else {
          $message = $cardVerification;
        }

        $response = response()->json($message);

        // $response = response()->json(['success' => true, 'message' => 'Complimenti! Il tuo acquisto è andato a buon fine!', 'info'=> $transactionMessage]);
        // $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        return $response;
      // } else {
      //   return response()->json($saleTransaction->message);

        // visualizzo in console il messaggio
        // Log::error($transactionResult->message);
        // return response()->json(['success' => false, 'message' => 'Purtroppo sembra ci sia qualche problema con il pagamento, controlla che tutti i campi inseriti siano corretti.']);
      // }
    } catch (\Exception $e) {
      // Cattura l'eccezione e loggala nel file di log
      Log::error($e->getMessage());

      $errorMessage = $e->getMessage();
      // Ottieni il messaggio di errore dall'eccezione
      // $errorMessage = "Qualcosa è andato storto con il tuo pagamento. Siamo al lavoro per risolvere il problema. Ci scusiamo per il disagio.";

      // Invia una risposta di errore al frontend
      return response()->json(['success' => false, 'message' => $errorMessage]);
    }
  }
}
