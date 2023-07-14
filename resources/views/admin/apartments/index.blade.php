@extends('layouts.admin')

@section('title')
  | Index
@endsection

@section('content')

@section("bg-title")
Appartamenti!
@endsection

@section("bg-subtitle")
Qui sono presenti i tuoi immobili in vendita.
@endsection

<div class="container py-5">

  <div class="box-card-long mb-5">
    <div class="card-md-description d-flex justify-content-between">
      <span>Immobili {count appartaments}</span>
      <div>
        <a href="{{route('admin.apartments.create')}}" class="btn btn-primary">Aggiungi appartamento</a>
      </div>
    </div>
  </div>


  <div class="box-card-long">

    <form id="standard-3" method="get" action="" id="form2">
      <input type="text" class="search-txt-input search-input" name="q" maxlength="100" placeholder="Inserisci il titolo...">
      <button type="submit" form="form2"  class="search-button">
        <i class="fa fa-search"></i>
      </button>
    </form>


          <div class="scroll">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Titolo</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Indirizzo</th>
                    <th scope="col">Stanze</th>
                    <th scope="col">Letti</th>
                    <th scope="col">Bagni</th>
                    <th scope="col">Metri quadrati</th>
                    <th scope="col">Prezzo</th>
                    <th scope="col">Dettagli</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apartments as $apartment)
                    <tr>
                        <td>{{$apartment->title}}</td>
                        <td>{{$apartment->category}}</td>
                        <td>{{$apartment->address}}</td>
                        <td>{{$apartment->n_rooms}}</td>
                        <td>{{$apartment->n_beds}}</td>
                        <td>{{$apartment->n_bathrooms}}</td>
                        <td>{{$apartment->square_meters}}</td>
                        <td>{{$apartment->price}}</td>
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


