@extends('layouts.admin')

@section('title')
  | Edit
@endsection

@section('content')

@section("jumbotron-title")
Modifica!
@endsection

@section("jumbotron-subtitle")
Puoi modificare i dettagli del tuo immobile.
@endsection


<div class="container">
  {{-- VERSIONE DESKTOP --}}
  <div class="box-card-long mb-5 d-none d-sm-block">
    <div class="card-md-description d-flex justify-content-between">
      <span>Modifica: {{$apartment->title}}</span>
      <div>
        <a href="{{route('admin.apartments.index')}}" class="btn btn-primary me-2">Torna all'elenco appartamenti</button>
        <a href="{{route('admin.home')}}" class="btn heavenly">Torna alla dashboard</a>
      </div>
    </div>
  </div>
  {{-- VERSIONE MOBILE --}}
  <div class="box-card-long mb-5 d-block d-sm-none">
    <div class="card-md-description d-flex align-items-center justify-content-between">
      <span class="fs-6">Modifica: {{$apartment->title}}</span>
      <div class="d-flex">
        <a href="{{route('admin.apartments.index')}}" class="btn btn-primary me-1"><i class="fa-solid fa-list"></i></button>
        <a href="{{route('admin.home')}}" class="btn btn-secondary"><i class="fa-solid fa-chart-line"></i></a>
      </div>
    </div>
  </div>

  <div class="box-card-long ">
    <form action="{{route('admin.apartments.update', $apartment)}}" method="POST" enctype="multipart/form-data">

        @csrf

        @method('PUT')

        {{-- Title --}}
      <div class="mb-3 input-boolbnb">
          <label class="form-label" for="title">Titolo</label>
          <input type="text"
          class="form-control w-75 @error('title') is-invalid @enderror"
          value="{{ old('title', $apartment->title) }}"
          id="title"
          name="title"
          placeholder="Inserisci un titolo"
          required
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
          value="{{ old('price', $apartment->price) }}"
          id="price"
          name="price"
          placeholder="Inserisci un prezzo"
          onblur="validatePrice()">
          <span id="price-error"></span>
          @error('price')
            <p class="text-danger">{{ $message }}</p>
          @enderror

      </div>

      {{-- Category --}}
      <div class="mb-3 input-boolbnb">
          <label class="form-label" for="category">Categoria</label>
          <input type="text"
          class="form-control w-75 @error('category') is-invalid @enderror"
          value="{{ old('category', $apartment->category) }}"
          id="category"
          name="category"
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
        value="{{ old('cover_image', $apartment->cover_image) }}"
        placeholder="Inserisci un'immagine di copertina"
        onchange="showImg(event)">
        <span id="img-error"></span>
        @error('cover_image')
          <p class="text-danger">{{ $message }}</p>
        @enderror

      </div>

      {{-- square_meters --}}
      <div class="mb-3 input-boolbnb">
        <label class="form-label" for="square_meters">Metri quadri</label>
        <input type="text"
        class="form-control w-75 @error('square_meters') is-invalid @enderror"
        value="{{ old('square_meters', $apartment->square_meters) }}"
        id="square_meters"
        name="square_meters"
        onblur="validateMeters()">
        <span id="meters-error"></span>
        @error('square_meters')
            <p class="text-danger">{{ $message }}</p>
        @enderror
      </div>

      {{-- Number of rooms --}}
      <div class="mb-3 input-boolbnb">
          <label class="form-label" for="n_rooms">Numero stanze</label>
          <input type="text"
          class="form-control w-75 @error('n_rooms') is-invalid @enderror"
          value="{{ old('n_rooms', $apartment->n_rooms) }}"
          id="n_rooms"
          name="n_rooms"
          onblur="validateRooms()">
          <span id="n-rooms-error"></span>
          @error('n_rooms')
            <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      {{-- Number of beds --}}
      <div class="mb-3 input-boolbnb">
          <label class="form-label" for="n_beds">Numero letti</label>
          <input type="text"
          class="form-control w-75 @error('n_beds') is-invalid @enderror"
          value="{{ old('n_beds', $apartment->n_beds) }}"
          id="n_beds"
          name="n_beds"
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
          class="form-control w-75 @error('n_bathrooms') is-invalid @enderror"
          value="{{ old('n_bathrooms', $apartment->n_bathrooms) }}"
          id="n_bathrooms"
          name="n_bathrooms"
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

                  @if (!$errors->any() && $apartment?->services->contains($service))
                    checked
                  @elseif ($errors->any() && in_array($service->id, old('services',[])))
                    checked
                  @endif
                >
                <label class="btn btn-outline-primary" for="service{{ $loop->iteration }}">{{ $service->name }}</label>
            @endforeach

          </div>

        </div>

      </div>

      {{-- Toggle visible --}}
      <div class="is-visible-check mb-3 form-check form-switch">
        <label class="form-label" for="is_visible">Rendi visibile il tuo appartamento</label>
        <input type="checkbox"
        class="form-control form-check-input"
        role="switch"
        id="is_visible"
        name="is_visible"
        value="1"
        @if ( old('is_visible', $apartment->is_visible))
          checked
        @endif>
      </div>

      <button type="submit" class="btn btn-primary">Conferma modifica</button>
    </form>
  </div>

</div>

  <script>

  // cover_image upload & validation

  const imgPreview = document.getElementById('img-preview');
  const imgTag = document.getElementById('cover_image');
  const imgClear = document.getElementById('img-clear');
  const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.webp)$/i;
  const noImgSrc = "@php echo $noImgSrc @endphp";

  function showImg(e) {
    if (!allowedExtensions.exec(imgTag.value)) {
      imgError.innerHTML = 'Immagine non valida';
      imgTag.value = '';
      imgPreview.src = noImgSrc;
      imgClear.classList.add('d-none');
      return false;
    }
    imgPreview.src = URL.createObjectURL(e.target.files[0]);
    imgClear.classList.remove('d-none');
    imgError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
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
    inputBox.setAttribute('required', true)
    inputBox.setAttribute('placeholder', 'Inserisci l\'indirizzo')
    inputBox.setAttribute('value', '{{ old("address", $apartment->address) }}')




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
      return false;
    }
    titleError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
  }

  function validatePrice(){

    const price = document.getElementById('price');
    const regex = /^[1-9]\d*(((\d{3}){1})?(\.\d{0,2})?)$/;

    if(parseFloat(price.value) < 1){
      priceError.innerHTML = 'Prezzo non valido';
      return false;
    }
    if(parseFloat(price.value) > 999.99){
      priceError.innerHTML = 'Prezzo non valido';
      return false;
    }
    if(!regex.test(price.value)){
      priceError.innerHTML = 'Prezzo non valido';
      return false;
    }

    price.value = !(isNaN(parseFloat(price.value))) ? parseFloat(price.value).toFixed(2) : '';
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
      categoryError.innerHTML = 'Categoria non valida';
      return false;
    }
    categoryError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
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
      return false;
    }
    if(!regex.test(meters)){
      metersError.innerHTML = 'Metri non validi';
      return false;
    }

    metersError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
  }

  function validateRooms(){
    const rooms = document.getElementById('n_rooms').value;
    const regex = /^\d+$/;

    if(parseInt(rooms) < 1){
      roomsError.innerHTML = 'Deve contenere almeno 1 stanza';
      return false;
    }
    if(!regex.test(rooms)){
      roomsError.innerHTML = 'Valore non valido';
      return false;
    }
    roomsError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
  }

  function validateBed(){
    const bed = document.getElementById('n_beds').value;
    const regex = /^\d+$/;

    if(parseInt(bed) < 1){
      bedError.innerHTML = 'Deve contenere almeno 1 letto';
      return false;
    }
    if(!regex.test(bed)){
      bedError.innerHTML = 'Valore non valido';
      return false;
    }

    bedError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
  }

  function validateBath(){
    const bath = document.getElementById('n_bathrooms').value;
    const regex = /^\d+$/;

    if(parseInt(bath) < 1){
      bathError.innerHTML = 'Deve contenere almeno 1 bagno';
      return false;
    }
    if(!regex.test(bath)){
      bathError.innerHTML = 'Valore non valido';
      return false;
    }

    bathError.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
  }

  </script>

@endsection
