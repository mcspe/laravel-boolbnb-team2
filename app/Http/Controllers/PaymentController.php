<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

      // Esegui il pagamento tramite Braintree
      $result = $gateway->transaction()->sale([
        'amount' => $sponsorship->price, // Importo della sponsorizzazione
        'paymentMethodNonce' => $nonce,
        'options' => [
          'submitForSettlement' => true
        ]
      ]);

      // Gestisci il risultato della transazione e invia una risposta al frontend
      if ($result->success) {
        $sponsorship->apartments()->save($apartment, [
          'payment_date' => $payment_date,
          'expiration_date' => $expiration_date,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now()
        ]);
        // return redirect()->route('admin.sponsorship', $apartment)->with('sponsorship_flag', true)->with('message', 'Complimenti! Il tuo acquisto è andato a buon fine!');
        // return response()->json(['success' => true, 'message' => 'Complimenti! Il tuo acquisto è andato a buon fine!', 'redirect_url' => "route('admin.sponsorship', $apartmentId)"]);
        $response = response()->json(['success' => true, 'message' => 'Complimenti! Il tuo acquisto è andato a buon fine!']);
        $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        return $response;
      } else {
        // visualizzo in console il messaggio
        Log::error($result->message);
        return response()->json(['success' => false, 'message' => 'Purtroppo sembra ci sia qualche problema con il pagamento, controlla che tutti i campi inseriti siano corretti.']);
      }
    } catch (\Exception $e) {
      // Cattura l'eccezione e loggala nel file di log
      Log::error($e->getMessage());

      // Ottieni il messaggio di errore dall'eccezione
      $errorMessage = "Qualcosa è andato storto con il tuo pagamento. Siamo al lavoro per risolvere il problema. Ci scusiamo per il disagio.";

      // Invia una risposta di errore al frontend
      return response()->json(['success' => false, 'message' => $errorMessage]);
    }
  }
}
