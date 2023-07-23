@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4 row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Nome</label>

                            <div class="col-md-6">
                                <input
                                  oninput="validateUserInput('name')"
                                  id="name"
                                  type="text"
                                  class="form-control @error('name') is-invalid @enderror"
                                  name="name"
                                  value="{{ old('name') }}"
                                  required
                                  autocomplete="name"
                                  autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="lastname" class="col-md-4 col-form-label text-md-right">Cognome</label>

                            <div class="col-md-6">
                                <input
                                  oninput="validateUserInput('lastname')"
                                  id="lastname"
                                  type="text"
                                  class="form-control @error('lastname') is-invalid @enderror"
                                  name="lastname"
                                  value="{{ old('lastname') }}"
                                  required
                                  autocomplete="lastname"
                                  autofocus>

                                @error('lastname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="date_of_birth" class="col-md-4 col-form-label text-md-right">Data di Nascita</label>

                            <div class="col-md-6">
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

                                  <span class="text-danger mt-2" id="dateErrorMsg"></span>

                                @error('date_of_birth')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Indirizzo Email</label>

                            <div class="col-md-6">
                                <input
                                  id="email"
                                  type="email"
                                  class="form-control @error('email') is-invalid @enderror"
                                  name="email"
                                  value="{{ old('email') }}"
                                  required
                                  autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                              <div class="input-group">
                                <input
                                  onkeyup="validatePw()"
                                  id="password"
                                  type="password"
                                  class="form-control @error('password') is-invalid @enderror"
                                  name="password"
                                  required
                                  autocomplete="new-password">
                                  <div class="input-group-append">
                                    <span class="input-group-text" onclick="showPw('password')">
                                        <i class="fas fa-eye py-1" id="togglePasswordIcon"></i>
                                    </span>
                                  </div>
                              </div>

                                  <span class="text-danger mt-2" id="errorMsg"></span>

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Conferma password</label>

                            <div class="col-md-6">
                              <div class="input-group">
                                <input
                                  onkeyup="passwordValidation()"
                                  id="password-confirm"
                                  type="password"
                                  class="form-control"
                                  name="password_confirmation"
                                  required
                                  autocomplete="new-password">
                                  <div class="input-group-append">
                                    <span class="input-group-text" onclick="showPw('password-confirm')">
                                        <i class="fas fa-eye py-1" id="togglePasswordIcon"></i>
                                    </span>
                                  </div>
                              </div>
                            </div>
                        </div>

                        <div class="mb-4 row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Registrati
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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

    const form = document.querySelector('form')

    const password = form.password;
    const password_confirmation = form.password_confirmation;

    const errorMsg = document.getElementById('errorMsg');

    if (password.value.length < 8 || password.value.length > 16) {
      password.classList.add('is-invalid')
      password.classList.remove('is-valid')
      errorMsg.innerHTML = 'la password deve essere di almeno 8 caratteri';
    } else {
      password.classList.add('is-valid');
      password.classList.remove('is-invalid');
      errorMsg.innerHTML = '';
    }
  }

    //////////////////////////////////////////////////////////////////

    // FUNZIONE VALIDAZIONE PASSWORD E CONFERMA PASSWORD

    function passwordMatch() {

      const form = document.querySelector('form')

      const password = form.password;
      const password_confirmation = form.password_confirmation;

      return (password.value === password_confirmation.value);
    }

    function passwordValidation() {

      const form = document.querySelector('form');

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
            dateErrorMsg.innerHTML = 'devi essere maggiorenne per registrarti';
        } else {
            dateOfBirthInput.classList.add('is-valid');
            dateOfBirthInput.classList.remove('is-invalid');
            dateErrorMsg.innerHTML = '';
        }
    }


</script>
