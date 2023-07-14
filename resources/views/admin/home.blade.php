@extends('layouts.admin')

@section('title')
  | Dashboard
@endsection

@section('content')

{{-- <div class="bg-home">
  <div class="welcome">
    <h1>ciao {{ Auth::user()->name }}! <i class="fa-solid fa-hand fa-shake" style="color: #ffd500;"></i></h1>
    <h4>Qui sono presenti tutte le statistiche della tua attività</h4>
  </div>
</div> --}}
@section("bg-title")
ciao {{ Auth::user()->name }}! <i class="fa-solid fa-hand fa-shake" style="color: #ffd500;"></i>
@endsection

@section("bg-subtitle")
Qui sono presenti tutte le statistiche della tua attività.
@endsection

  <div class="d-flex justify-content-center">

    <a href="{{route("admin.apartments.index")}}" class="blue">
    <div class="box-card d-flex">
      <div class="circle-img text-center green-circle">
        <i class="fa-solid fa-house-user"></i>
      </div>
      <div class="card-md-description">
        <span>Appartamenti</span>
        <div class="bold">
          <span>110</span>
        </div>
      </div>
    </div>
    </a>


    <div class="box-card d-flex ">
      <div class="circle-img text-center blue-circle ">
        <i class="fa-solid fa-list-ol"></i>
      </div>
      <div class="card-md-description ">
        <span>Elenco Appartamenti</span>
        <div class="bold">
          <span>1</span>
        </div>
      </div>
    </div>




    <div class="box-card d-flex">
      <div class="circle-img text-center red-circle">
        <i class="fa-solid fa-signal"></i>
      </div>
      <div class="card-md-description">
        <span>Visite</span>
        <div class="bold">
          <span>333</span>
        </div>
      </div>
    </div>
  </div>




  @endsection






