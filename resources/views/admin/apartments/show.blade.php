@extends('layouts.admin')

@section('title')
  | Show
@endsection

@section('content')


@section("jumbotron-title")
Dettagli {{$apartment->category}}!
@endsection

@section("jumbotron-subtitle")
Qui sono presenti i dettagli dell'immobile selezionato.
@endsection

<div class="container ">

  <div class="box-card-long-show ">
    <div class="card-md-description d-flex justify-content-between">
      <span>{{$apartment->category}}: {{$apartment->title}}</span>
      <div>
        <a href="{{route('admin.apartments.edit', $apartment)}}" class="btn btn-warning">Modifica</a>
        @include('admin.partials.delete-form')
        <a href="{{route('admin.apartments.index')}}" class="btn btn-primary">Torna alla dashboard</a>
      </div>
    </div>
  </div>

  <div class="d-flex">

    {{-- LEFT-SIDE --}}
    <div class="left-side">

      <div class="box-image">
        <img src="{{$apartment->cover_image}}" alt="">
      </div>

      <div class="description-box">
        <div class="price">
          <h4>Prezzo: {{$apartment->price}}€</h4>
          <h4>Metri quadrati: {{$apartment->square_meters}}&#13217;
          </h4>
        </div>

        <div class="house-specifications">
          <span><i  class="fa-solid fa-door-open"></i>     {{$apartment->n_rooms}}</span>
          <span><i class="fa-solid fa-bed"></i>     {{$apartment->n_beds}}</span>
          <span><i class="fa-solid fa-bath"></i>     {{$apartment->n_bathrooms}}</span>
        </div>
      </div>

    </div>

    {{-- RIGHT-SIDE --}}
    <div class="right-side">

      <div class="description-box">
        <i class="fa-solid fa-location-dot"></i>
        <span>{{$apartment->address}}</span>
      </div>
      <div id="map" style="width: 400px; height: 300px"></div>
    </div>

  </div>

  <a href="{{route('admin.sponsorships.index')}}" class="btn btn-primary my-3">Sponsorizza appartamento</a>
</div>



  <script type="text/javascript">

    // INSERT LONGITUDE AND LATITUDE
    let center= [14.293223,40.907766]
    const map = tt.map({
      key:"D2uJigXaa5sTIMlRGUwMoZ5dmwOA1HlB",
      container: "map",
      center: center,
      zoom: 10
    })
    map.on('load', () =>{
      new tt.Marker().setLngLat(center).addTo(map)
    })
  </script>
@endsection




