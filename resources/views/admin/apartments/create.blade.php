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
      <div class="mb-3">
          <label class="form-label">Indirizzo</label>
          <input type="text"
          class="form-control w-75 @error('address') is-invalid @enderror"
          id="address"
          name="address"
          value="{{ old('address') }}"
          placeholder="Inserisci l'indirizzo">
          @error('address')
            <p class="text-danger">{{ $message }}</p>
          @enderror
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

      <button type="submit" class="btn btn-primary">Invia</button>

    </form>
  </div>
</div>

@endsection
