@extends('layouts.admin')

@section('title')
  | Sponsorships
@endsection

@section('content')

  @section("jumbotron-title")
  Sponsorizzazioni
  @endsection

  @section("jumbotron-subtitle")
  Qui sono presenti le sponsorizzazioni disponibili
  @endsection

  <div class="container">
    <div class="box-card-long-show">
        <div class="card-md-description d-flex justify-content-between">
            <span>Scegli il piano per spostare il tuo appartamento in evidenza</span>
        </div>
    </div>

    {{-- Cards container --}}
    <div class="d-flex">
        @foreach ($sponsorships as $index => $sponsorship)
        <div class="mc card p-3">
            <div class="card-desc">
                <div class="card-function">
                    <h3>{{$sponsorship->name}}</h3>
                    <span class="d-block py-1">
                        <strong class="text-grey pt-1">{{$sponsorship->price}}&euro;</strong>
                    </span>
                    <em class="d-block py-1">
                        /mese
                    </em>
                    <p class="py-1">
                        <i class="fa-regular fa-clock me-1"></i>
                        <strong>{{$sponsorship->duration}} ore</strong>
                    </p>
                    <button type="button" class="btn btn-primary text-white d-block w-100" data-bs-toggle="modal" data-bs-target="#exampleModal{{$index}}">
                        Acquista
                    </button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal{{$index}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"> <strong> {{$sponsorship->name}} </strong></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span class="me-5">Prezzo : <strong>{{$sponsorship->price}}&euro; </strong><em>/mese</em></span>
                        <span>Durata : <i class="fa-regular fa-clock me-1"></i><strong>{{$sponsorship->duration}} ore</strong></span>

                        <div id="dropin-container{{$index}}"></div>
                        <div id="checkout-message{{$index}}"></div>
                        <button id="submit-button{{$index}}" class="btn btn-primary">Procedi al pagamento</button>
                    </div>
                </div>
            </div>
        </div>

        @endforeach
    </div>
</div>

<script>
    @foreach ($sponsorships as $index => $sponsorship)
    var button{{$index}} = document.querySelector('#submit-button{{$index}}');

    braintree.dropin.create({
        authorization: 'sandbox_6mwgnxhd_9p8qk2vxsp79grrb',
        container: '#dropin-container{{$index}}',
        locale:'it_IT'
    }, function (createErr, instance) {
        button{{$index}}.addEventListener('click', function () {
            instance.requestPaymentMethod(function (requestPaymentMethodErr, payload) {
                // Quando l'utente fa clic sul pulsante 'Procedi al pagamento', questo codice invierà le
                // informazioni di pagamento crittografate in una variabile chiamata "payment method nonce"
                $.ajax({
                    type: 'POST',
                    url: '/checkout',
                    data: {'paymentMethodNonce': payload.nonce}
                }).done(function(result) {
                    // Smonta l'interfaccia utente di Drop-in
                    instance.teardown(function (teardownErr) {
                        if (teardownErr) {
                            console.error('Could not tear down Drop-in UI!');
                        } else {
                            console.info('Drop-in UI has been torn down!');
                            // Rimuovi il pulsante 'Procedi al pagamento'
                            $('#submit-button{{$index}}').remove();
                        }
                    });

                    if (result.success) {
                        $('#checkout-message{{$index}}').html('<h1>Success</h1><p>Your Drop-in UI is working! Check your <a href="https://sandbox.braintreegateway.com/login">sandbox Control Panel</a> for your test transactions.</p><p>Refresh to try another transaction.</p>');
                    } else {
                        console.log(result);
                        $('#checkout-message{{$index}}').html('<h1>Error</h1><p>Check your console.</p>');
                    }
                });
            });
        });
    });
    @endforeach
</script>

@endsection
