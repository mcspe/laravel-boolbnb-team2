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

  <div class="box-card-long mb-5 ">

    <div class="card-md-description d-flex justify-content-between">
      <span>Modifica: {{$apartment->title}}</span>
      <div>
        <a href="{{route('admin.apartments.index')}}" class="btn btn-primary">Torna all'elenco appartamenti</button>
        <a href="{{route('admin.home')}}" class="btn heavenly">Torna alla dashboard</a>
      </div>
    </div>

  </div>

  <div class="box-card-long ">
    <form action="{{route('admin.apartments.update', $apartment)}}" method="POST" enctype="multipart/form-data">

        @csrf

        @method('PUT')

        {{-- Title --}}
      <div class="mb-3">
          <label class="form-label">Titolo</label>
          <input type="text"
          class="form-control w-75"
          value="{{ old('title', $apartment->title) }}"
          id="title"
          name="title"
          placeholder="Inserisci un titolo">
      </div>

      {{-- Price --}}
      <div class="mb-3">
          <label class="form-label">Prezzo</label>
          <input type="number"
          class="form-control w-75"
          value="{{ old('price', $apartment->price) }}"
          id="price"
          name="price"
          placeholder="Inserisci un titolo">
      </div>

      {{-- Category --}}
      <div class="mb-3">
          <label class="form-label">Categoria</label>
          <input type="text"
          class="form-control w-75"
          value="{{ old('category', $apartment->category) }}"
          id="title"
          name="category"
          placeholder="Inserisci categoria">
      </div>

      {{-- Address --}}
      <div class="mb-3">
          <label class="form-label">Indirizzo</label>
          <input type="text"
          class="form-control w-75"
          value="{{ old('address', $apartment->address) }}"
          id="address"
          name="address"
          placeholder="Inserisci l'indirizzo">
      </div>

      {{-- square_meters --}}
      <div class="mb-3">
        <label class="form-label">Metri quadri</label>
        <input type="number"
        class="form-control w-75"
        value="{{ old('square_meters', $apartment->square_meters) }}"
        id="square_meters"
        name="square_meters">
      </div>

      {{-- Number of rooms --}}
      <div class="mb-3">
          <label class="form-label">Numero stanze</label>
          <input type="number"
          class="form-control w-75"
          value="{{ old('n_rooms', $apartment->n_rooms) }}"
          id="n_rooms"
          name="n_rooms">
      </div>

      {{-- Number of beds --}}
      <div class="mb-3">
          <label class="form-label">Numero letti</label>
          <input type="number"
          class="form-control w-75"
          value="{{ old('n_beds', $apartment->n_beds) }}"
          id="n_beds"
          name="n_beds">
      </div>

      {{-- Number of bathrooms --}}
      <div class="mb-3">
          <label class="form-label">Numero bagni</label>
          <input type="number"
          class="form-control w-75"
          value="{{ old('n_bathrooms', $apartment->n_bathrooms) }}"
          id="n_bathrooms"
          name="n_bathrooms">
      </div>

      <button type="submit" class="btn btn-primary">Conferma modifica</button>
    </form>
  </div>

</div>

@endsection
