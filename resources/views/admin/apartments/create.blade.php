@extends('layouts.admin')

@section('title')
  | Create
@endsection

@section('content')

@section("bg-title")
Aggiungi immobile!
@endsection

@section("bg-subtitle")
Puoi inserire un nuovo immobile in vendita.
@endsection

<div class="container py-5">

<div class="box-card-long mb-5">
  <div class="card-md-description d-flex justify-content-between">
    <span>Aggiungi un nuovo immobile</span>
    <div>
      <button type="submit" class="btn btn-primary">Invia</button>
      <a href="{{route('admin.home')}}" class="btn heavenly">Torna alla dashboard</a>
    </div>
  </div>
</div>

<div class="box-card-long">
  <form action="{{route('admin.apartments.store')}}" method="POST">
    @csrf


    {{-- Title --}}
    <div class="mb-3">
        <label class="form-label">Titolo</label>
        <input type="text"
        class="form-control w-75
        id="title"
        name="title"
        placeholder="Inserisci un titolo">
    </div>

    {{-- Price --}}
    <div class="mb-3">
        <label class="form-label">Prezzo</label>
        <input type="number"
        class="form-control w-75
        id="price"
        name="price"
        placeholder="Inserisci un titolo">
    </div>

    {{-- Category --}}
    <div class="mb-3">
        <label class="form-label">Categoria</label>
        <input type="text"
        class="form-control w-75
        id="title"
        name="category"
        placeholder="Inserisci categoria">
    </div>

    {{-- Address --}}
    <div class="mb-3">
        <label class="form-label">Indirizzo</label>
        <input type="text"
        class="form-control w-75
        id="address"
        name="address"
        placeholder="Inserisci l'indirizzo">
    </div>

    {{-- Number of rooms --}}
    <div class="mb-3">
        <label class="form-label">Numero stanze</label>
        <input type="number"
        class="form-control w-75
        id="n_rooms"
        name="n_rooms">
    </div>

    {{-- Number of beds --}}
    <div class="mb-3">
        <label class="form-label">Numero letti</label>
        <input type="number"
        class="form-control w-75
        id="n_beds"
        name="n_beds">
    </div>

    {{-- Number of bathrooms --}}
    <div class="mb-3">
        <label class="form-label">Numero bagni</label>
        <input type="number"
        class="form-control w-75
        id="n_bathrooms"
        name="n_bathrooms">
    </div>

    <button type="submit" class="btn btn-primary">Invia</button>
</form>
</div>
</div>
@endsection
