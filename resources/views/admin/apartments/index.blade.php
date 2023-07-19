@extends('layouts.admin')

@section('title')
  | Index
@endsection

@section('content')

@section("jumbotron-title")
Appartamenti!
@endsection

@section("jumbotron-subtitle")
Qui sono presenti i tuoi immobili in vendita.
@endsection


<div class="container">

  <div class="box-card-long mb-5">
    <div class="card-md-description d-flex justify-content-between">
      <span>Immobili {{$n_apartments}}</span>
      <a href="{{route('admin.apartments.create')}}" class="btn btn-primary">Aggiungi immobile</a>
    </div>
  </div>


  <div class="box-card-long">

    <form id="standard-3" method="get" action="" id="form2">
      <input type="text" class="search-txt-input search-input" name="q" maxlength="100" placeholder="Inserisci il titolo...">
      <button type="submit" form="form2"  class="search-button">
        <i class="fa fa-search"></i>
      </button>
    </form>


    <div class="size">
      <table class="table">

        <thead>
          <tr>
            <th scope="col">Titolo</th>
            <th scope="col" class="d-xsm-none">Categoria</th>
            <th scope="col" class="d-xsm-none">Indirizzo</th>
            <th scope="col" class="d-xsm-none">Stanze</th>
            <th scope="col" class="d-xsm-none">Letti</th>
            <th scope="col" class="d-xsm-none">Bagni</th>
            <th scope="col" class="d-xsm-none">Metri quadrati</th>
            <th scope="col" class="d-xsm-none">Prezzo</th>
            <th scope="col">Dettagli</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($apartments as $apartment)
            <tr>
              <td>{{$apartment->title}}</td>
              <td class="d-xsm-none">{{$apartment->category}}</td>
              <td class="d-xsm-none">{{$apartment->address}}</td>
              <td class="d-xsm-none">{{$apartment->n_rooms}}</td>
              <td class="d-xsm-none">{{$apartment->n_beds}}</td>
              <td class="d-xsm-none">{{$apartment->n_bathrooms}}</td>
              <td class="d-xsm-none">{{$apartment->square_meters}}</td>
              <td class="d-xsm-none">{{$apartment->price}}</td>
              <td>
                <a href="{{route('admin.apartments.show', $apartment)}}" class="btn btn-primary">Vai</a>
              </td>
            </tr>
          @endforeach
        </tbody>

      </table>
    </div>

  </div>

</div>

@endsection


