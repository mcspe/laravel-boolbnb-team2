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

  {{-- VERSIONE DESKTOP --}}
  <div class="box-card-long mb-5 d-none d-sm-block">
    <div class="card-md-description d-flex justify-content-between">
      {{-- If n_apartments is >= 1 i see the count of total apartments --}}
      @if ($n_apartments >= 1)
        <span>Totale immobili: {{$n_apartments}}</span>
        {{-- Else i see a span and the button for create new apartment --}}
      @else
        <span>Non ci sono appartamenti.<br>Aggiungine uno per iniziare!</span>
        <a href="{{route('admin.apartments.create')}}" class="btn btn-primary">Aggiungi immobile</a>
      @endif
    </div>
  </div>

  {{-- VERSIONE MOBILE --}}
  <div class="box-card-long mb-5 d-block d-sm-none">
    <div class="card-md-description d-flex align-items-center justify-content-between">
      {{-- If n_apartments is >= 1 i see the count of total apartments --}}
      @if ($n_apartments >= 1)
        <span class="fs-6">Totale immobili: {{$n_apartments}}</span>
        {{-- Else i see a span and the button for create new apartment --}}
      @else
        <span class="fs-6">Non ci sono appartamenti.<br>Aggiungine uno per iniziare!</span>
        <a href="{{route('admin.apartments.create')}}" class="btn btn-primary"><i class="fa-solid fa-plus"></i></a>
      @endif
    </div>
  </div>

  <div class="box-card-long mb-5 d-none" id="sessionMessage">

      @if (session('deleted'))
        <span class="text-success">
            {{ session('deleted') }}
        </span>
      @endif

      @if (session('not_authorized'))
        <span class="text-danger">
            {{ session('not_authorized') }}
        </span>
      @endif

  </div>

  {{-- If n_apartments is >= 1 i see the table with loaded apartments --}}
  @if ($n_apartments >= 1)
    <div class="box-card-long">

      <div class="form-button d-flex justify-content-between">


        {{-- RIMOSSA LA BARRA DI RICERCA PERCHÈ NON FUNZIONA --}}

        {{-- <div class="form-container">

          <form id="standard-3" method="get" action="" id="form2">
            <input type="text" class="search-txt-input search-input" name="q" maxlength="100" placeholder="Inserisci il titolo...">
            <button type="submit" form="form2"  class="search-button">
              <i class="fa fa-search"></i>
            </button>
          </form>

        </div> --}}

        {{-- VERSIONE DESKTOP --}}
        <div class="button-container d-none d-sm-block">
          <a href="{{route('admin.apartments.create')}}" class="btn btn-primary m-3">Aggiungi immobile</a>
        </div>
        {{-- VERSIONE MOBILE --}}
        <div class="button-container d-block d-sm-none">
          <a href="{{route('admin.apartments.create')}}" class="btn btn-primary m-3"><i class="fa-solid fa-plus fa-lg"></i></a>
        </div>

      </div>


      <div class="size">
        <table class="table">

          <thead>
            <tr>
              <th scope="col">Nome</th>
              {{-- <th scope="col" class="d-xsm-none">Categoria</th> --}}
              <th scope="col" class="d-xsm-none">Indirizzo</th>
              {{-- <th scope="col" class="d-xsm-none">Stanze</th> --}}
              {{-- <th scope="col" class="d-xsm-none">Letti</th> --}}
              {{-- <th scope="col" class="d-xsm-none">Bagni</th> --}}
              {{-- <th scope="col" class="d-xsm-none">m²</th> --}}
              {{-- <th scope="col" class="d-xsm-none">Prezzo</th> --}}
              <th scope="col" class="d-xsm-none text-center">Visibile</th>
              <th scope="col" class="d-xsm-none text-center">Sponsorizzato</th>
              <th scope="col" class="text-center action">Azioni</th>
              {{-- <th scope="col"></th>
              <th scope="col"></th> --}}
            </tr>
          </thead>

          <tbody>
            @foreach ($apartments as $index => $apartment)
              <tr>
                <td>{{$apartment->title}}</td>
                {{-- <td class="d-xsm-none">{{$apartment->category}}</td> --}}
                <td class="d-xsm-none">{{$apartment->address}}</td>
                {{-- <td class="d-xsm-none">{{$apartment->n_rooms}}</td> --}}
                {{-- <td class="d-xsm-none">{{$apartment->n_beds}}</td> --}}
                {{-- <td class="d-xsm-none">{{$apartment->n_bathrooms}}</td> --}}
                {{-- <td class="d-xsm-none">{{$apartment->square_meters}}</td> --}}
                {{-- <td class="d-xsm-none">{{$apartment->price}}</td> --}}
                {{-- <td class="d-xsm-none">{{$apartment->is_visible}}</td> --}}
                <td class="d-xsm-none text-center">
                  @if ($apartment->is_visible > 0)
                    <span class="text-success"><i class="fa-solid fa-check fa-lg" style="color: #1ED760;"></i></span>
                  @else
                    <span class="text-danger"><i class="fa-solid fa-xmark fa-xl" style="color: #DC3545;"></i></span>
                  @endif
                </td>
                <td class="d-xsm-none text-center">
                  @if ($apartment->sponsorships->count() > 0)
                    <span class="text-success"><i class="fa-solid fa-check fa-lg" style="color: #1ED760;"></i></span>
                  @else
                    <span class="text-danger"><i class="fa-solid fa-xmark fa-xl" style="color: #DC3545;"></i></span>
                  @endif
                </td>
                <td class="text-center action">
                  <a href="{{route('admin.apartments.show', $apartment)}}" class="btn btn-primary me-1"><i class="fa-solid fa-eye"></i></a>
                  <a href="{{route('admin.apartments.edit', $apartment)}}" class="btn btn-warning ms-1 me-2"><i class="fa-solid fa-pencil"></i></a>
                  @include('admin.partials.delete-form')
                </td>
                {{-- <td>
                </td>
                <td>
                </td> --}}
              </tr>
            @endforeach
          </tbody>

        </table>
      </div>

    </div>
    @else
    {{-- Else i see nothing --}}
    @endif



</div>

<script>
  const sessionMessage = document.getElementById('sessionMessage');
  if(sessionMessage.childElementCount != 0){
    sessionMessage.classList.remove('d-none');
    const myTimeout = setTimeout(hideMessage, 5000);

    function hideMessage() {
      sessionMessage.classList.add('d-none');
    }
  }
</script>
@endsection


