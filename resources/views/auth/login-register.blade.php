@extends('layouts.admin')

@section('content')
    <div class="container-logreg" id="logreg">
        <div class="forms-container">
            <div class="signin-signup">
                {{-- ///////////////////////////////////////////////////////////////////////////////////////////////// --}}
                <!-- Login form -->
                <form method="POST" action="{{ route('login') }}" class="login-register sign-in-form">
                    @csrf
                    <h2 class="title">Accedi</h2>
                    {{-- email --}}
                    <div class="input-field mb-4">
                        <i class="fas fa-user"></i>
                        <input
                          id="email"
                          type="email"
                          class="form-control @error('email') is-invalid @enderror"
                          name="email"
                          value="{{ old('email') }}"
                          required
                          autocomplete="email"
                          autofocus
                          placeholder="Email">

                          @error('email')
                          <span class="mt-1 invalid-feedback" style="width: 280px; margin-left:5.5rem" role="alert">
                              <strong>{{$message}}</strong>
                          </span>
                        @enderror
                    </div>
                    {{-- password --}}
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input
                          id="password"
                          type="password"
                          class="form-control @error('password') is-invalid @enderror"
                          name="password"
                          required
                          autocomplete="current-password"
                          placeholder="Password">

                        @error('password')
                            <span class="invalid-feedback mb-3" style="width: 280px; margin-left:5.5rem" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- fine del form di accesso --}}
                    <button type="submit" class="btn-logreg mt-3">
                      Accedi
                    </button>
                </form>
                {{-- ///////////////////////////////////////////////////////////////////////////////////////////////// --}}
                <!-- Register form -->
                <form method="POST" action="{{ route('register') }}" class="login-register sign-up-form">
                    @csrf
                    <h2 class="title">Registrati</h2>

                    {{-- nome --}}
                    <div class="input-field mb-3">
                        <i class="fas fa-user"></i>
                        <input
                          oninput="validateUserInput('name')"
                          id="name"
                          type="text"
                          class="form-control @error('name') is-invalid @enderror"
                          name="name"
                          value="{{ old('name') }}"
                          required
                          autocomplete="name"
                          autofocus
                          placeholder="Nome">

                        @error('name')
                            <span class="mt-1 invalid-feedback" style="width: 280px; margin-left:52px" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- cognome --}}
                    <div class="input-field mb-3">
                        <i class="fas fa-user"></i>
                        <input
                          oninput="validateUserInput('lastname')"
                          id="lastname"
                          type="text"
                          class="form-control @error('lastname') is-invalid @enderror"
                          name="lastname"
                          value="{{ old('lastname') }}"
                          required
                          autocomplete="lastname"
                          autofocus
                          placeholder="Cognome">

                        @error('lastname')
                            <span class="mt-1 invalid-feedback" style="width: 280px; margin-left: 52px" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- data di nascita --}}
                    <div class="input-field mb-3">
                        <i class="fas fa-calendar"></i>
                        <input
                          onchange="validateDateOfBirth()"
                          id="date_of_birth"
                          type="date"
                          class="form-control @error('date_of_birth') is-invalid @enderror"
                          name="date_of_birth"
                          value="{{ old('date_of_birth') }}"
                          required
                          autocomplete="date_of_birth"
                          autofocus>

                        <div class="error-container">
                          <span class="text-danger mt-2" id="dateErrorMsg"></span>
                        </div>

                        @error('date_of_birth')
                            <span class="invalid-feedback"  role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- email --}}
                    <div class="input-field mb-3">
                        <i class="fas fa-envelope"></i>
                        <input
                          id="email"
                          type="email"
                          class="form-control @error('email') is-invalid @enderror"
                          name="email"
                          value="{{ old('email') }}"
                          required
                          autocomplete="email"
                          placeholder="Email">

                        <span class="text-danger mt-2" id="dateErrorMsg"></span>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- password --}}
                    <div class="input-field mb-3">
                        <i class="fas fa-lock"></i>
                        <input
                          onkeyup="validatePw()"
                          id="password"
                          type="password"
                          class="form-control @error('password') is-invalid @enderror"
                          name="password"
                          required
                          autocomplete="new-password"
                          placeholder="Password">

                        {{-- <div class="input-group-append">
                            <span class="input-group-text" onclick="showPw('password')">
                                <i class="fas fa-eye py-1" id="togglePasswordIcon"></i>
                            </span>
                        </div> --}}
                        <div class="error-container">
                          <span class="text-danger" id="errorMsg"></span>
                        </div>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- conferma password --}}
                    <div class="input-field mb-3">
                        <i class="fas fa-lock"></i>
                        <input
                          onkeyup="passwordValidation()"
                          id="password-confirm"
                          type="password"
                          class="form-control"
                          name="password_confirmation"
                          required
                          autocomplete="new-password"
                          placeholder="Conferma Password">

                        {{-- <div class="input-group-append">
                            <span class="input-group-text" onclick="showPw('password-confirm')">
                                <i class="fas fa-eye py-1" id="togglePasswordIcon"></i>
                            </span>
                        </div> --}}

                        <div class="error-container">
                          <span class="text-danger" id="errorMsg"></span>
                        </div>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- fine form registrazione segue bottone --}}
                    <button onclick="submitRegisterForm()" class="btn-logreg">
                      Registrati
                  </button>
                </form>
            </div>
        </div>
        {{-- a seguire i due pannelli laterali ai form di login e registrazione --}}
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <img class="logo-bnb ms-3 w-25" src="logo-standard.png" alt="logo_boolbnb">
                    <h2>Prima volta qui?</h2>
                    <p>Effettuando la registrazione potrai iniziare ad aggiungere e gestire gli appartamenti!<br>Cosa aspetti ?</p>
                    <button class="btn-logreg transparent" id="sign-up-btn">Registrati</button>
                  </div>
                  <!-- Add your login form image here -->
                  <img src="img/log.svg" class="image" alt="" />
                </div>
                <div class="panel right-panel">
                  <div class="content">
                    <img class="logo-bnb ms-3 w-25" src="logo-standard.png" alt="logo_boolbnb">
                    <h2>Sei già dei nostri?</h2>
                    <p>Entra nella tua area personale, aggiungi o gestisci i tuoi appartamenti.<br>Controlla se hai ricevuto messaggi e valuta se sponsorizzare uno dei tuoi appartamenti!</p>
                    <button class="btn-logreg transparent" id="sign-in-btn">Accedi</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        // FUNZIONE VALIDAZIONE NOME E COGNOME

        function validateUserInput(id) {

            const inputValue = document.getElementById(id).value;

            const regex = /^[a-zA-Z\s]{2,}$/;

            if (regex.test(inputValue)) {
                document.getElementById(id).classList.add('is-valid');
                document.getElementById(id).classList.remove('is-invalid');
            } else {
                document.getElementById(id).classList.add('is-invalid');
                document.getElementById(id).classList.remove('is-valid');
            }
        }

        //////////////////////////////////////////////////////////////////

        // VALIDAZIONE LUNGHEZZA PASSWORD

        function validatePw() {

            const form = document.querySelector('.sign-up-form')

            const password = form.password;
            const password_confirmation = form.password_confirmation;

            const errorMsg = document.getElementById('errorMsg');

            if (password.value.length < 8 || password.value.length > 16) {
                password.classList.add('is-invalid')
                password.classList.remove('is-valid')
                errorMsg.innerHTML = 'La password deve essere di almeno 8 caratteri';
            } else {
                password.classList.add('is-valid');
                password.classList.remove('is-invalid');
                errorMsg.innerHTML = '';
            }
        }

        //////////////////////////////////////////////////////////////////

        // FUNZIONE VALIDAZIONE PASSWORD E CONFERMA PASSWORD

        function passwordMatch() {

            const form = document.querySelector('.sign-up-form')

            const password = form.password;
            const password_confirmation = form.password_confirmation;

            return (password.value === password_confirmation.value);
        }

        function passwordValidation() {

            console.log('sto scrivendo nel campo password');

            const form = document.querySelector('.sign-up-form');

            console.log(form, 'il form');

            const password_confirmation = form.password_confirmation;

            if (passwordMatch()) {
                console.log(passwordMatch());
                password_confirmation.classList.add('is-valid');
                password_confirmation.classList.remove('is-invalid');
            } else {
                console.warn(passwordMatch());
                password_confirmation.classList.remove('is-valid');
                password_confirmation.classList.add('is-invalid');
            }
        }

        //////////////////////////////////////////////////////////////////

        // FUNZIONE PER MOSTRARE PASSWORD

        function showPw(id) {

            const show = document.getElementById(id);

            if (show.type === 'password') {
                show.type = 'text'
            } else {
                show.type = 'password'
            }
        }

        //////////////////////////////////////////////////////////////////

        // FUNZIONE VALIDAZIONE DATA DI NASCITA -  OBBLIGO MAGGIORENNE

        function validateDateOfBirth() {
            const dateOfBirthInput = document.getElementById('date_of_birth');
            const dateOfBirth = new Date(dateOfBirthInput.value);
            const currentDate = new Date();

            const minBirthdate = new Date(currentDate.getFullYear() - 18, currentDate.getMonth(), currentDate.getDate());

            const dateErrorMsg = document.getElementById('dateErrorMsg');

            if (dateOfBirth > currentDate || dateOfBirth > minBirthdate) {
                dateOfBirthInput.classList.add('is-invalid');
                dateOfBirthInput.classList.remove('is-valid');
                dateErrorMsg.innerHTML = 'Devi essere maggiorenne per registrarti';
            } else {
                dateOfBirthInput.classList.add('is-valid');
                dateOfBirthInput.classList.remove('is-invalid');
                dateErrorMsg.innerHTML = '';
            }
        }

        //////////////////////////////////////////////////////////////////

        // TRANSIZIONE LOGIN - REGISTRATI


        document.addEventListener("DOMContentLoaded", function() {
        const sign_in_btn = document.querySelector("#sign-in-btn");
        const sign_up_btn = document.querySelector("#sign-up-btn");
        const container = document.getElementById("logreg");

        console.log(container);
        console.log(sign_in_btn);
        console.log(sign_up_btn);

        sign_up_btn.addEventListener("click", () => {
          container.classList.add("sign-up-mode");
          console.log('sto cliccando');
        });

        sign_in_btn.addEventListener("click", () => {
          container.classList.remove("sign-up-mode");
          console.log('sto cliccando');
        });
      });


      // funzione invio form di registrazione
      const form = document.querySelector('.sign-up-form');

      console.log(form, 'ho schiacciato form per registrarmi');

      function submitRegisterForm() {


        form.submit();

      }


    </script>
@endsection

