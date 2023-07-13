@extends('layouts.admin')

@section('title')
  | Show
@endsection

@section('content')
<div class="card" style="width: 25rem;">
    {{-- <img src="..." class="card-img-top" alt="..."> --}}
    <div class="card-body">
      <h3 class="card-title pb-2">{{$apartment->title}}</h3>
      <p><strong>Prezzo:</strong> {{$apartment->price}}€</p>
      <p><strong>Categoria:</strong> {{$apartment->category}}</p>
      <p><strong>Indirizzo:</strong> {{$apartment->address}}</p>
      <p><strong>Numero stanze:</strong> {{$apartment->n_rooms}}</p>
      <p><strong>Numero letti:</strong> {{$apartment->n_beds}}</p>
      <p><strong>Numero bagni:</strong> {{$apartment->n_bathrooms}}</p>
      <p><strong>Metri quadrati:</strong> {{$apartment->square_meters}}m²</p>
      <p>{{$apartment->cover_image}}</p>
      <a href="{{route('admin.apartments.edit', $apartment)}}" class="btn btn-primary">Modifica Appartamento</a>
      <a href="{{route('admin.apartments.index')}}" class="btn btn-primary">Torna ad Appartamenti</a>
    </div>
  </div>
@endsection

