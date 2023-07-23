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
          <label class="form-label" for="title">Titolo</label>
          <input type="text"
          class="form-control w-75 @error('title') is-invalid @enderror"
          id="title"
          name="title"
          value="{{ old('title') }}"
          placeholder="Inserisci un titolo"
          onblur="validateTitle()">
          <span id="title-error"></span>
          @error('title')
            <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      {{-- Price --}}
      <div class="mb-3 input-boolbnb">
          <label class="form-label" for="price">Prezzo</label>
          <input type="text"
          class="form-control w-75 @error('price') is-invalid @enderror"
          id="price"
          name="price"
          value="{{ old('price') }}"
          placeholder="Inserisci un prezzo"
          onblur="validatePrice()">
          <span id="price-error"></span>
          @error('price')
            <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      {{-- Category --}}
      <div class="mb-3 input-boolbnb ">
          <label class="form-label" for="category">Categoria</label>
          <input type="text"
          class="form-control w-75 @error('category') is-invalid @enderror"
          id="category"
          name="category"
          value="{{ old('category') }}"
          placeholder="Inserisci categoria"
          onblur="validateCategory()">
          <span id="category-error"></span>
          @error('category')
            <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      {{-- Address --}}
      <div class="mb-3" id="searchbox">
          <label class="form-label" for="address">Indirizzo</label>
          <span id="address-error"></span>
          @error('address')
          <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      {{-- Cover Image --}}
      <div class="mb-3 input-boolbnb">

        <label class="form-label" for="cover_image">Immagine di Copertina</label>

        <div class="img-preview position-relative d-flex justify-content-center align-items-center p-3" title="Aggiungi un immagine" onclick="openfile()">
          <img id="img-preview" src="{{ $src }}" alt="" width="100">
          <div class="position-absolute" id="img-clear" onclick="clearImg(event)">
            <i class="fa-solid fa-xmark"></i>
          </div>
        </div>

        <input type="file"
        class="form-control w-75 @error('cover_image') is-invalid @enderror"
        id="cover_image"
        name="cover_image"
        value="{{ old('cover_image') }}"
        placeholder="Inserisci un'immagine di copertina"
        onchange="showImg(event)">
        <span id="img-error"></span>
        @error('cover_image')
          <p class="text-danger">{{ $message }}</p>
        @enderror

      </div>

      {{-- square_meters --}}
      <div class="mb-3 input-boolbnb ">
        <label class="form-label" for="square_meters">Metri quadri</label>
        <input type="text"
        class="form-control w-75 @error('square_meters') is-invalid @enderror"
        id="square_meters"
        name="square_meters"
        value="{{ old('square_meters') }}"
        onblur="validateMeters()">
        <span id="meters-error"></span>
        @error('square_meters')
          <p class="text-danger">{{ $message }}</p>
        @enderror
      </div>

      {{-- Number of rooms --}}
      <div class="mb-3 input-boolbnb ">
          <label class="form-label" for="n_rooms">Numero stanze</label>
          <input type="text"
          class="form-control w-75 @error('n_rooms') is-invalid @enderror"
          id="n_rooms"
          name="n_rooms"
          value="{{ old('n_rooms') }}"
          onblur="validateRooms()">
          <span id="n-rooms-error"></span>
          @error('n_rooms')
            <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      {{-- Number of beds --}}
      <div class="mb-3 input-boolbnb ">
          <label class="form-label" for="n_beds">Numero letti</label>
          <input type="text"
          class="form-control w-75 @error('n_beds') is-invalid @enderror"
          id="n_beds"
          name="n_beds"
          value="{{ old('n_beds') }}"
          onblur="validateBed()">
          <span id="n-bed-error"></span>
          @error('n_beds')
            <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      {{-- Number of bathrooms --}}
      <div class="mb-3 input-boolbnb">
          <label class="form-label" for="n_bathrooms">Numero bagni</label>
          <input type="text"
          class=" form-control w-75 @error('n_bathrooms') is-invalid @enderror"
          id="n_bathrooms"
          name="n_bathrooms"
          value="{{ old('n_bathrooms') }}"
          onblur="validateBath()">
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

  let formValidated = false;

  function validateForm() {
    return formValidated;
  }

  // cover_image upload & validation

  const imgPreview = document.getElementById('img-preview');
  const imgTag = document.getElementById('cover_image');
  const imgClear = document.getElementById('img-clear');
  imgClear.classList.add('d-none');
  const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.webp)$/i;
  const noImgSrc = "@php echo $src @endphp";

  function showImg(e) {
    if (!allowedExtensions.exec(imgTag.value)) {
      imgError.innerHTML = 'Immagine non valida';
      imgTag.value = '';
      imgPreview.src = noImgSrc;
      imgClear.classList.add('d-none');
      formValidated = false;
      return false;
    }
    imgPreview.src = URL.createObjectURL(e.target.files[0]);
    imgClear.classList.remove('d-none');
    formValidated = true;
    imgError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
  }

  function clearImg(e) {
    e.stopPropagation();
    imgPreview.src = noImgSrc;
    imgTag.value = '';
    imgClear.classList.add('d-none');
    imgError.innerHTML = '';
  }

  function openfile() {
    imgTag.click();
  }

  // autocomplete searchbox
  const apiKey = @php echo json_encode(env('API_IT_KEY'));  @endphp;

  const options = {

	autocompleteOptions : {
	key: apiKey,
	language: 'it-IT',
	},

	searchOptions : {
	key: apiKey,
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
    const title = document.getElementById('title').value.trim();

    if(!title.match(/[A-Za-z\s]{5,}/g)){
      titleError.innerHTML = 'Titolo non valido';
      formValidated = false;
      return false;
    }
    formValidated = true;
    titleError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
  }

  function validatePrice(){

    const price = document.getElementById('price');
    const regex = /^[1-9]\d*(((\d{3}){1})?(\.\d{0,2})?)$/;

    if(parseFloat(price.value) < 1){
      priceError.innerHTML = 'Prezzo non valido';
      formValidated = false;
      return false;
    }
    if(parseFloat(price.value) > 999.99){
      priceError.innerHTML = 'Prezzo non valido';
      formValidated = false;
      return false;
    }
    if(!regex.test(price.value)){
      priceError.innerHTML = 'Prezzo non valido';
      formValidated = false;
      return false;
    }

    price.value = !(isNaN(parseFloat(price.value))) ? parseFloat(price.value).toFixed(2) : '';
    formValidated = true;
    priceError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';

  }

  function validateCategory(){
    const category = document.getElementById('category').value;
    if(category.length == 0){
      categoryError.innerHTML = 'Categoria non valida';
      formValidated = false;
      return false;
    }
    if(!category.match(/[A-Za-z]/g)){
      categoryError.innerHTML = 'Categoria non valida';
      formValidated = false;
      return false;
    }
    formValidated = true;
    categoryError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
  }

  // function validateAddress(){
  //   const address = document.getElementById('address').value;
  //   if(address.length === 0){
  //     addressError.innerHTML = 'L\'indirizzo non esiste';
  //     return false;
  //   }

  //   addressError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
  //   return true;
  // }

  function validateMeters(){
    const meters = document.getElementById('square_meters').value;
    const regex = /^\d+$/;

    if(parseInt(meters) < 20){
      metersError.innerHTML = 'Deve contenere minimo 20 mq';
      formValidated = false;
      return false;
    }
    if(!regex.test(meters)){
      metersError.innerHTML = 'Metri non validi';
      formValidated = false;
      return false;
    }
    formValidated = true;
    metersError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
  }

  function validateRooms(){
    const rooms = document.getElementById('n_rooms').value;
    const regex = /^\d+$/;

    if(parseInt(rooms) < 1){
      roomsError.innerHTML = 'Deve contenere almeno 1 stanza';
      formValidated = false;
      return false;
    }
    if(!regex.test(rooms)){
      roomsError.innerHTML = 'Valore non valido';
      formValidated = false;
      return false;
    }
    formValidated = true;
    roomsError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
  }

  function validateBed(){
    const bed = document.getElementById('n_beds').value;
    const regex = /^\d+$/;

    if(parseInt(bed) < 1){
      bedError.innerHTML = 'Deve contenere almeno 1 letto';
      formValidated = false;
      return false;
    }
    if(!regex.test(bed)){
      bedError.innerHTML = 'Valore non valido';
      formValidated = false;
      return false;
    }
    formValidated = true;
    bedError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
  }

  function validateBath(){
    const bath = document.getElementById('n_bathrooms').value;
    const regex = /^\d+$/;

    if(parseInt(bath) < 1){
      bathError.innerHTML = 'Deve contenere almeno 1 bagno';
      formValidated = false;
      return false;
    }
    if(!regex.test(bath)){
      bathError.innerHTML = 'Valore non valido';
      formValidated = false;
      return false;
    }
    formValidated = true;
    bathError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
  }
</script>

@endsection
