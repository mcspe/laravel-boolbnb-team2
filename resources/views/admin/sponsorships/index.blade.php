@extends('layouts.admin')

@section('title')
  | Sponsorships
@endsection

@section('content')

  @section("jumbotron-title")
  Sponsorizzazioni
  @endsection

  @section("jumbotron-subtitle")
  Qui sono presenti le sponsorizzazioni disponibili
  @endsection

  <div class="container">

    <div class="box-card-long-show">
      <div class="card-md-description d-flex justify-content-between">
        <span>Scegli il piano per spostare il tuo appartamento in evidenza</span>
      </div>
    </div>

    {{-- Cards container --}}
    <div class="d-flex">

      @foreach ($sponsorships as $sponsorship)
        <div class="mc card p-3">
          <div class="card-desc">
            <div class="card-function">
                <h3>{{$sponsorship->name}}</h3>

                <span class="d-block py-1">
                    <strong clas="text-grey pt-1">{{$sponsorship->price}}&euro;</strong>
                </span>

                <em class="d-block py-1">
                    /mese
                </em>

                <p class="py-1">
                  <i class="fa-regular fa-clock me-1"></i>
                  <strong>{{$sponsorship->duration}} ore</strong>
                </p>

                <a class="btn btn-primary text-white d-block">
                    Acquista
                </a>
              </div>
          </div>
        </div>
      @endforeach


  </div>

@endsection
