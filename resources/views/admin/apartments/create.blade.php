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


<div class="container ">

  <div class="box-card-long mb-5 ">
    <div class="card-md-description d-flex justify-content-between">
      <span>Aggiungi un nuovo immobile</span>
      <div>
        <button type="submit" class="btn btn-primary d-xsm-none">Invia</button>
        <a href="{{route('admin.home')}}" class="btn heavenly">Torna alla dashboard</a>
      </div>
    </div>
  </div>


  <div class="box-card-long">
    <form action="{{route('admin.apartments.store')}}" method="POST" enctype="multipart/form-data">

      @csrf

      {{-- Title --}}
      <div class="mb-3">
          <label class="form-label">Titolo</label>
          <input type="text"
          class="form-control w-75 @error('title') is-invalid @enderror"
          id="title"
          name="title"
          value="{{ old('title') }}"
          placeholder="Inserisci un titolo">
          @error('title')
            <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      {{-- Price --}}
      <div class="mb-3">
          <label class="form-label">Prezzo</label>
          <input type="number"
          step='0.01'
          class="form-control w-75 @error('price') is-invalid @enderror"
          id="price"
          name="price"
          value="{{ old('price') }}"
          placeholder="Inserisci un titolo">
          @error('price')
            <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      {{-- Category --}}
      <div class="mb-3">
          <label class="form-label">Categoria</label>
          <input type="text"
          class="form-control w-75 @error('category') is-invalid @enderror"
          id="title"
          name="category"
          value="{{ old('category') }}"
          placeholder="Inserisci categoria">
          @error('category')
            <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      {{-- Address --}}
      <div class="mb-3" id="searchbox">
          <label class="form-label">Indirizzo</label>
          {{-- <input type="text"
          class="form-control tt-search-box-input w-75 @error('address') is-invalid @enderror"
          id="address"
          name="address"
          type="text"
          autocomplete="off"
          value="{{ old('address') }}"
          placeholder="Inserisci l'indirizzo"> --}}
          @error('address')
            <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      {{-- Cover Image --}}
      <div class="mb-3">
          <label class="form-label">Immagine di Copertina</label>
          <input type="file"
          class="form-control w-75 @error('cover_image') is-invalid @enderror"
          id="cover_image"
          name="cover_image"
          value="{{ old('cover_image') }}"
          placeholder="Inserisci l'indirizzo"
          onchange="showImg(event)">
          @error('cover_image')
            <p class="text-danger">{{ $message }}</p>
          @enderror

        <div class="img-preview m-5 position-relative">
          <img id="img-preview" src="{{ $src }}" alt="" width="100">
          <div class="position-absolute" id="img-clear" onclick="clearImg()"><span>X</span></div>
        </div>
      </div>

      {{-- square_meters --}}
      <div class="mb-3">
        <label class="form-label">Metri quadri</label>
        <input type="number"
        class="form-control w-75 @error('square_meters') is-invalid @enderror"
        id="square_meters"
        name="square_meters"
        value="{{ old('square_meters') }}">
        @error('square_meters')
          <p class="text-danger">{{ $message }}</p>
        @enderror
      </div>

      {{-- Number of rooms --}}
      <div class="mb-3">
          <label class="form-label">Numero stanze</label>
          <input type="number"
          class="form-control w-75 @error('n_rooms') is-invalid @enderror"
          id="n_rooms"
          name="n_rooms"
          value="{{ old('n_rooms') }}">
          @error('n_rooms')
            <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      {{-- Number of beds --}}
      <div class="mb-3">
          <label class="form-label">Numero letti</label>
          <input type="number"
          class="form-control w-75 @error('n_beds') is-invalid @enderror"
          id="n_beds"
          name="n_beds"
          value="{{ old('n_beds') }}">
          @error('n_beds')
            <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      {{-- Number of bathrooms --}}
      <div class="mb-3">
          <label class="form-label">Numero bagni</label>
          <input type="number"
          class="form-control w-75 @error('n_bathrooms') is-invalid @enderror"
          id="n_bathrooms"
          name="n_bathrooms"
          value="{{ old('n_bathrooms') }}">
          @error('n_bathrooms')
            <p class="text-danger">{{ $message }}</p>
          @enderror
      </div>

      <div class="mb-3">
        <h5 class="form-label">Servizi</h5>
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

</script>

@endsection
