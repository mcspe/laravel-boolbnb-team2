@extends('layouts.admin')

@section('title')
  | Sponsorships
@endsection

@section('content')

@section('jumbotron-title')
  Sponsorizzazioni
@endsection

@section('jumbotron-subtitle')
  Qui sono presenti le sponsorizzazioni disponibili
@endsection
<style>
  .loader {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    position: relative;
    animation: rotate 1s linear infinite
  }

  .loader::before,
  .loader::after {
    content: "";
    box-sizing: border-box;
    position: absolute;
    inset: 0px;
    border-radius: 50%;
    border: 5px solid #FFF;
    animation: prixClipFix 2s linear infinite;
  }

  .loader::after {
    border-color: #FF3D00;
    animation: prixClipFix 2s linear infinite, rotate 0.5s linear infinite reverse;
    inset: 6px;
  }

  @keyframes rotate {
    0% {
      transform: rotate(0deg)
    }

    100% {
      transform: rotate(360deg)
    }
  }

  @keyframes prixClipFix {
    0% {
      clip-path: polygon(50% 50%, 0 0, 0 0, 0 0, 0 0, 0 0)
    }

    25% {
      clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 0, 100% 0, 100% 0)
    }

    50% {
      clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 100% 100%, 100% 100%)
    }

    75% {
      clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 0 100%, 0 100%)
    }

    100% {
      clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 0 100%, 0 0)
    }
  }
</style>

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
            <h3>{{ $sponsorship->name }}</h3>
            <span class="d-block py-1">
              <strong class="text-grey pt-1">{{ $sponsorship->price }}&euro;</strong>
            </span>
            <p class="py-1">
              <i class="fa-regular fa-clock me-1"></i>
              <strong>{{ $sponsorship->duration }} ore</strong>
            </p>
            <button type="button"
              class="btn btn-primary text-white d-block w-100"
              data-bs-toggle="modal"
              data-bs-target="#exampleModal{{ $index }}">
              Acquista
            </button>
          </div>
        </div>
      </div>

      <div class="modal fade"
        id="exampleModal{{ $index }}"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5"
                id="exampleModalLabel"> <strong> {{ $sponsorship->name }} </strong></h1>
              <button type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <span class="me-5">Prezzo : <strong>{{ $sponsorship->price }}&euro; </strong></span>
              <span>Durata : <i class="fa-regular fa-clock me-1"></i><strong>{{ $sponsorship->duration }}
                  ore</strong></span>

              <div id="dropin-container{{ $index }}"></div>
              <div id="checkout-message{{ $index }}"></div>
              <button id="submit-button{{ $index }}"
                class="btn btn-primary">Procedi al pagamento</button>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
{{-- <span class="loader"></span> --}}

<script>
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  @foreach ($sponsorships as $index => $sponsorship)
    const button{{ $index }} = document.querySelector('#submit-button{{ $index }}');

    braintree.dropin.create({
      authorization: 'sandbox_s95rsm2d_64mms2kchj3rp5zs',
      container: '#dropin-container{{ $index }}',
      locale: 'it_IT'
    }, function(createErr, instance) {
      button{{ $index }}.addEventListener('click', function() {
        instance.requestPaymentMethod(function(requestPaymentMethodErr, payload) {
          if (!requestPaymentMethodErr) {
            // Quando l'utente fa clic sul pulsante 'Procedi al pagamento', questo codice invierà le
            // informazioni di pagamento crittografate in una variabile chiamata "payment method nonce"
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': csrfToken
              },
              type: 'POST',
              url: '{{ route('admin.checkout') }}',
              data: {
                'paymentMethodNonce': payload.nonce,
                'sponsorshipPrice': {{ $sponsorship->price }}
              }
            }).done(function(result) {
              // Smonta l'interfaccia utente di Drop-in
              instance.teardown(function(teardownErr) {

                if (teardownErr) {
                  console.error('Could not tear down Drop-in UI!');
                } else {
                  console.info('Drop-in UI has been torn down!');
                  // Rimuovi il pulsante 'Procedi al pagamento'
                  $('#submit-button{{ $index }}').remove();
                }
              });

              if (result.success) {
                $('#checkout-message{{ $index }}').html(
                  '<h1>Success</h1><p>Your Drop-in UI is working! Check your <a href="https://sandbox.braintreegateway.com/login">sandbox Control Panel</a> for your test transactions.</p><p>Refresh to try another transaction.</p>'
                );
                console.log('ok');
              } else {
                console.log(result);
                $('#checkout-message{{ $index }}').html(
                  '<h1>Error</h1><p>Check your console.</p>');
              }
            });
          }
        });
      });
    });
  @endforeach
</script>

@endsection
