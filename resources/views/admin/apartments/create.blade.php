@extends('layouts.admin')

@section('title')
  | Create
@endsection

@section('content')

@section("jumbotron-title")
Aggiungi immobile!
@endsection

@section("jumbotron-subtitle")
Puoi inserire un nuovo immobile in vendita.
@endsection


<div class="container">

  <div class="box-card-long mb-5">
    <div class="card-md-description d-flex justify-content-between">
      <span>Aggiungi un nuovo immobile</span>
      <div>
        <a href="{{route('admin.apartments.index')}}" class="btn btn-primary d-xsm-none">Vai all'elenco appartamenti</button>
        <a href="{{route('admin.home')}}" class="btn heavenly">Torna alla dashboard</a>
      </div>
    </div>
  </div>


  <div class="box-card-long">
    <form action="{{route('admin.apartments.store')}}" method="POST" enctype="multipart/form-data" class="form-boolbnb">

      @csrf

      {{-- Title --}}
      <div class="mb-3 input-boolbnb">
          <label class="">Titolo</label>
          <input type="text"
          class="form-control w-75 @error('title') is-invalid @enderror"
          id="title"
          name="title"
          value="{{ old('title') }}"
          placeholder="Inserisci un titolo"
          onkeyup="validateTitle()"
          onclick="validateTitle()">
          <span id="title-error"></span>
          @error('title')
            <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      {{-- Price --}}
      <div class="mb-3 input-boolbnb">
          <label>Prezzo</label>
          <input type="text"
          class="form-control w-75 @error('price') is-invalid @enderror"
          id="price"
          name="price"
          value="{{ old('price') }}"
          placeholder="Inserisci un titolo"
          onkeyup="validatePrice()"
          onclick="validatePrice()">
          <span id="price-error"></span>
          @error('price')
            <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      {{-- Category --}}
      <div class="mb-3 input-boolbnb ">
          <label>Categoria</label>
          <input type="text"
          class="form-control w-75 @error('category') is-invalid @enderror"
          id="category"
          name="category"
          value="{{ old('category') }}"
          placeholder="Inserisci categoria"
          onkeyup="validateCategory()"
          onclick="validateCategory()">
          <span id="category-error"></span>
          @error('category')
            <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      {{-- Address --}}
      <div class="mb-3" id="searchbox">
          <label>Indirizzo</label>
          <span id="address-error"></span>
          @error('address')
          <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      {{-- Cover Image --}}
      <div class="mb-3 input-boolbnb">
          <label>Immagine di Copertina</label>
          <input type="file"
          class="form-control w-75 @error('cover_image') is-invalid @enderror"
          id="cover_image"
          name="cover_image"
          value="{{ old('cover_image') }}"
          placeholder="Inserisci l'indirizzo"
          onkeyup="validateImg()"
          onclick="validateImg()"
          onchange="showImg(event)">
          <span id="img-error"></span>
          @error('cover_image')
            <p class="text-danger">{{ $message }}</p>
          @enderror

        <div class="img-preview m-5 position-relative">
          <img id="img-preview" src="{{ $src }}" alt="" width="100">
          <div class="position-absolute" id="img-clear" onclick="clearImg()"><span>X</span></div>
        </div>
      </div>

      {{-- square_meters --}}
      <div class="mb-3 input-boolbnb ">
        <label>Metri quadri</label>
        <input type="text"
        class="form-control w-75 @error('square_meters') is-invalid @enderror"
        id="square_meters"
        name="square_meters"
        value="{{ old('square_meters') }}"
        onkeyup="validateMeters()"
        onclick="validateMeters()">
        <span id="meters-error"></span>
        @error('square_meters')
          <p class="text-danger">{{ $message }}</p>
        @enderror
      </div>

      {{-- Number of rooms --}}
      <div class="mb-3 input-boolbnb ">
          <label>Numero stanze</label>
          <input type="text"
          class="form-control w-75 @error('n_rooms') is-invalid @enderror"
          id="n_rooms"
          name="n_rooms"
          value="{{ old('n_rooms') }}"
          onkeyup="validateRooms()"
          onclick="validateRooms()">
          <span id="n-rooms-error"></span>
          @error('n_rooms')
            <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      {{-- Number of beds --}}
      <div class="mb-3 input-boolbnb ">
          <label>Numero letti</label>
          <input type="text"
          class="form-control w-75 @error('n_beds') is-invalid @enderror"
          id="n_beds"
          name="n_beds"
          value="{{ old('n_beds') }}"
          onkeyup="validateBed()"
          onclick="validateBed()">
          <span id="n-bed-error"></span>
          @error('n_beds')
            <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      {{-- Number of bathrooms --}}
      <div class="mb-3 input-boolbnb">
          <label>Numero bagni</label>
          <input type="text"
          class=" form-control w-75 @error('n_bathrooms') is-invalid @enderror"
          id="n_bathrooms"
          name="n_bathrooms"
          value="{{ old('n_bathrooms') }}"
          onkeyup="validateBath()"
          onclick="validateBath()">
          <span id="n-bath-error"></span>
          @error('n_bathrooms')
            <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      <div class="mb-3">
        <h5 class="form-label"><strong>Servizi</strong></h5>
        <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">

          <div class="d-flex flex-wrap gap-1" role="group" aria-label="Basic checkbox toggle button group">

            @foreach ($services as $service)
                <input
                  id="service{{ $loop->iteration }}"
                  class="btn-check"
                  autocomplete="off"
                  type="checkbox"
                  value="{{ $service->id }}"
                  name="services[]"

                  @if (in_array($service->id, old('services', [])))
                    checked
                  @endif

                >
                <label class="btn btn-outline-secondary" for="service{{ $loop->iteration }}">{{ $service->name }}</label>
            @endforeach

          </div>

        </div>

      </div>

      <button type="submit" class="btn btn-primary">Invia</button>

    </form>
  </div>
</div>

<script>

  // cover_image upload

  const imgPreview = document.getElementById('img-preview');
  const imgTag = document.getElementById('cover_image');
  const imgClear = document.getElementById('img-clear');
  imgClear.classList.add('d-none');

  function showImg(e) {
    imgPreview.src = URL.createObjectURL(e.target.files[0]);
    imgClear.classList.remove('d-none');
  }

  function clearImg() {
    imgPreview.src = "http://127.0.0.1:8000/storage/uploads/img-placeholder.png";
    imgTag.value = '';
    imgClear.classList.add('d-none');
  }

  // autocomplete searchbox

  const options = {

	autocompleteOptions : {
	key: 'jMP7C6DHaaq8PNVgJUg740ueeMPlH0xY',
	language: 'it-IT',
	},

	searchOptions : {
	key: 'jMP7C6DHaaq8PNVgJUg740ueeMPlH0xY',
	language: 'it-IT',
	limit: 10,
	// idxSet: 'Str'
	}

}

  const ttSearchBox = new tt.plugins.SearchBox(tt.services, options)
  const searchBoxHTML = ttSearchBox.getSearchBoxHTML()

  const searchBoxContainer = document.getElementById('searchbox');

  searchBoxContainer.append(searchBoxHTML)

  const inputBox = searchBoxHTML.firstChild.children[2]

  inputBox.setAttribute('name', 'address')
  inputBox.setAttribute('autocomplete', 'off')
  inputBox.setAttribute('placeholder', 'Inserisci l\'indirizzo')
  inputBox.setAttribute('value', '{{ old("address") }}')




  const titleError = document.getElementById('title-error')
  const priceError = document.getElementById('price-error')
  const categoryError = document.getElementById('category-error')
  const addressError = document.getElementById('address-error')
  const imgError = document.getElementById('img-error')
  const metersError = document.getElementById('meters-error')
  const roomsError = document.getElementById('n-rooms-error')
  const bedError = document.getElementById('n-bed-error')
  const bathError = document.getElementById('n-bath-error')

  function validateTitle(){
    const title = document.getElementById('title').value;
    if(title.length == 0){
      titleError.innerHTML = 'Titolo non valido';
      return false;
    }
    if(!title.match(/[A-Za-z]/g)){
      titleError.innerHTML = 'Titolo non valido';
      return false;
    }
    titleError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
  }

  function validatePrice(){
    const price = document.getElementById('price').value;
    console.log(parseInt(price));
    if(price.length == 0){
      priceError.innerHTML = 'Prezzo non valido';
      return false;
    }
    if(parseFloat(price) > 999.99){
      priceError.innerHTML = 'Prezzo non valido';
      return false;
    }
    if(!price.match(/[0-9]/)){
      priceError.innerHTML = 'Prezzo non valido';
      return false;
    }

    priceError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;

  }

  function validateCategory(){
    const category = document.getElementById('category').value;
    if(category.length == 0){
      categoryError.innerHTML = 'Categoria non valida';
      return false;
    }
    if(!category.match(/[A-Za-z]/g)){
      categoryError.innerHTML = 'Categoria non valido';
      return false;
    }
    categoryError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
  }

  function validateAddress(){
    const address = document.getElementById('address').value;
    if(address.length === 0){
      addressError.innerHTML = 'L\'indirizzo non esiste';
      return false;
    }

    addressError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
  }

  function validateImg(){
    const img = document.getElementById('cover_image').value;
    if(img.length == 0){
      imgError.innerHTML = 'Immagine non valida';
      return false;
    }

    imgError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
  }

  function validateMeters(){
    const meters = document.getElementById('square_meters').value;
    if(parseInt(meters) < 20){
      metersError.innerHTML = 'Deve contenere minimo 20 mq';
      return false;
    }
    if(!meters.match(/[0-9]/)){
      metersError.innerHTML = 'Metri non validi';
      return false;
    }

    metersError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
  }

  function validateRooms(){
    const rooms = document.getElementById('n_rooms').value;
    if(parseInt(rooms) < 1){
      roomsError.innerHTML = 'Deve contenere almeno 1 stanza';
      return false;
    }
    if(!rooms.match(/[0-9]/)){
      roomsError.innerHTML = 'Valore non valido';
      return false;
    }
    roomsError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
  }

  function validateBed(){
    const bed = document.getElementById('n_beds').value;
    if(parseInt(bed) < 1){
      bedError.innerHTML = 'Deve contenere almeno 1 letto';
      return false;
    }
    if(!bed.match(/[0-9]/)){
      bedError.innerHTML = 'Valore non valido';
      return false;
    }

    bedError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
  }

  function validateBath(){
    const bath = document.getElementById('n_bathrooms').value;
    if(parseInt(bath) < 20){
      bathError.innerHTML = 'Deve contenere almeno 1 bagno';
      return false;
    }
    if(!bath.match(/[0-9]/)){
      bathError.innerHTML = 'Valore non valido';
      return false;
    }

    bathError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
  }
</script>

@endsection
