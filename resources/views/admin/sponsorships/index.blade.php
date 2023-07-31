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

<div class="container">
  <span id="sponsoredFlag" hidden>{{$sponsored_flag}}</span>
  <div class="box-card-long-show mb-5">
    <div class="card-md-description d-flex justify-content-between">
      @if ($sponsored_flag)
        <span class="fs-6">Congratulazioni! Hai sponsorizzato l'appartamento <strong>{{ $apartment->title }}</strong>! Sarà ora <strong>in evidenza</strong> nella nostra sezione dedicata.</span>
      @else
        <span class="fs-6">Scegli il piano per spostare il tuo appartamento in evidenza</span>
      @endif
    </div>
  </div>

  @if ($sponsored_flag)
    {{-- Active Sponsorship --}}
    <div class="box-card-long mb-3">
      <p>Hai acquistato il pacchetto di sponsorizzazione <strong>{{ $activeSponsorship['name'] }}</strong> per <strong>{{ $apartment->title }}</strong> in data <strong>{{ $activeSponsorship['startDate'] }}</strong>, attivo fino al <strong>{{ $activeSponsorship['endDate'] }}</strong> alle ore <strong>{{ $activeSponsorship['endTime'] }}</strong>.</p>
      <p>Potrai acquistare un nuovo pacchetto al termine della Sponsorizzazione attiva.</p>
    </div>
  @else
    {{-- Cards container VERSIONE DESKTOP --}}
    <div class="sponsorships-container d-flex mb-5">
      @foreach ($sponsorships as $index => $sponsorship)
        <div class="mc card p-3 mb-3">
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
                <div id="custom-loader{{ $index }}" class="custom-loader d-none justify-content-center align-items-center p-5">
                  <span class="loader"></span>
                </div>
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
  @endif

</div>

<script>
  let sponsoredFlag = document.getElementById('sponsoredFlag').innerHTML;
  sponsoredFlag = parseInt(sponsoredFlag);
  // console.log('sponsoredflag',sponsoredFlag);
  if(!sponsoredFlag){
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    @foreach ($sponsorships as $index => $sponsorship)
      const button{{ $index }} = document.querySelector('#submit-button{{ $index }}');
      const customLoader{{ $index }} = document.getElementById('custom-loader{{ $index }}');
      const modalBody{{ $index }} = document.getElementById('exampleModal{{ $index }}').children[0].children[0].children[1];

      function showCustomLoader{{ $index }}() {
        for (let i = 1; i < modalBody{{$index}}.children.length; i++) {
          modalBody{{$index}}.children[i].setAttribute("hidden", true);
        }
        customLoader{{$index}}.classList.add('d-flex');
        customLoader{{$index}}.classList.remove('d-none');
      }

      function hideCustomLoader{{$index}}() {
        customLoader{{$index}}.classList.remove('d-flex');
        customLoader{{$index}}.classList.add('d-none');
        modalBody{{$index}}.children[4].hidden = false;
      }

      function paymentCompleted() {
        setTimeout(() => {
          location.reload(true);
        }, 3000);
      }

      braintree.dropin.create({
        authorization: 'sandbox_s95rsm2d_64mms2kchj3rp5zs',
        container: '#dropin-container{{ $index }}',
        locale: 'it_IT',
        card: {
          cardholderName: {
            required: true
          },
          // overrides: {
          //   fields: {
          //     cardholderName: {
          //       prefill: "{{ Auth::user()->name }} {{ Auth::user()->lastname }}"
          //     },
          //     number: {
          //       prefill: '4111 1111 1111 1111',
          //       formatInput: true // Turn off automatic formatting
          //     },
          //     expirationDate: {
          //       prefill: '09/25'
          //     }
          //   }
          // }
        }
      }, function(createErr, instance) {
        button{{ $index }}.addEventListener('click', function() {
          instance.requestPaymentMethod(function(requestPaymentMethodErr, payload) {
            if (!requestPaymentMethodErr) {
              showCustomLoader{{ $index }}();
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
                  'apartmentId': {{$apartment->id}},
                  'sponsorshipId': {{$sponsorship->id}}
                }
              }).done(function(result) {
                // Smonta l'interfaccia utente di Drop-in
                instance.teardown(function(teardownErr) {

                  if (teardownErr) {
                    hideCustomLoader{{$index}}();
                    console.error('Could not tear down Drop-in UI!');
                  } else {
                    console.log('risposta di successo', result);
                    console.info('Drop-in UI has been torn down!');
                    // Rimuovi il pulsante 'Procedi al pagamento'
                    $('#submit-button{{ $index }}').remove();
                  }
                });

                if (result.success) {
                  hideCustomLoader{{$index}}();
                  $('#checkout-message{{ $index }}').html(
                    `<div class="success-checkmark">
                      <div class="check-icon">
                        <span class="icon-line line-tip"></span>
                        <span class="icon-line line-long"></span>
                        <div class="icon-circle"></div>
                        <div class="icon-fix"></div>
                      </div>
                    </div>
                    <h1>${result.message}</h1>
                    <p>Attendi il ricaricamento della pagina per verificare lo stato della tua sponsorizzazione.</p>`
                  );
                } else {
                  hideCustomLoader{{$index}}();
                  $('#checkout-message{{ $index }}').html(
                    `<div class="denied-checkmark">
                      <div class="circle-border"></div>
                      <div class="circle">
                        <div class="error"></div>
                      </div>
                    </div>
                    <h5>${result.message}</h5>
                    <p>Attendi il ricaricamento della pagina per eseguire una nuova operazione.</p>`
                  );
                }
                paymentCompleted();
              });
            }
          });
        });
      });
    @endforeach
  }
</script>

@endsection
