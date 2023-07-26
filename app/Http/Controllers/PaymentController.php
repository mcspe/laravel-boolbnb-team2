<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Braintree\Transaction;
use Braintree\Gateway;

class PaymentController extends Controller
{
  public function checkout(Request $request){
    try {
      $nonce = $request->input('paymentMethodNonce');
      $price = $request->input('sponsorshipPrice');

      // Crea un'istanza di Gateway con i parametri di configurazione
      $gateway = new Gateway([
        'environment' => config('services.braintree.environment'),
        'merchantId' => config('services.braintree.merchant_id'),
        'publicKey' => config('services.braintree.public_key'),
        'privateKey' => config('services.braintree.private_key'),
      ]);

      // Esegui il pagamento tramite Braintree
      $result = $gateway->transaction()->sale([
        'amount' => $price, // Importo della sponsorizzazione
        'paymentMethodNonce' => $nonce,
        'options' => [
          'submitForSettlement' => true
        ]
      ]);

      // Gestisci il risultato della transazione e invia una risposta al frontend
      if ($result->success) {
        return response()->json(['success' => true]);
      } else {
        return response()->json(['success' => false, 'message' => $result->message]);
      }
    } catch (\Exception $e) {
      // Cattura l'eccezione e loggala nel file di log
      Log::error($e->getMessage());

      // Ottieni il messaggio di errore dall'eccezione
      $errorMessage = $e->getMessage();

      // Invia una risposta di errore al frontend
      return response()->json(['success' => false, 'message' => $errorMessage]);
    }
  }
}
