@extends('layouts.admin')

@section('title')
  | Show
@endsection

@section('content')

  @section("jumbotron-title")
    Dettagli {{$apartment->category}}
  @endsection

  @section("jumbotron-subtitle")
    Qui sono presenti i dettagli dell'immobile selezionato.
  @endsection

  <div class="container">

    {{-- VERSIONE DESKTOP --}}
    <div class="box-card-long-show d-none d-sm-block">
      <div class="card-md-description d-flex justify-content-between">
        <span>
          @if ($apartment->category)
            {{$apartment->category}}:
          @endif
          {{$apartment->title}}
        </span>
        <div>
          <a href="{{route('admin.apartments.edit', $apartment)}}" class="btn btn-warning"><i class="fa-solid fa-pencil"></i></a>
          @include('admin.partials.delete-form', ['index' => $apartment->id])
          <a href="{{route('admin.apartments.index')}}" class="btn btn-primary d-xsm-none"><i class="fa-solid fa-list"></i></a>
        </div>
      </div>
    </div>
    {{-- VERSIONE MOBILE --}}
    <div class="box-card-long-show d-flex align-items-center justify-content-between d-block d-sm-none">
      <div class="card-md-description d-flex justify-content-between">
        <span class="fs-5">
          @if ($apartment->category)
            {{$apartment->category}}:
          @endif
          {{$apartment->title}}
        </span>
      </div>
        <div class="d-flex justify-content-between">
          <a href="{{route('admin.apartments.edit', $apartment)}}" class="btn btn-warning me-1"><i class="fa-solid fa-pencil"></i></a>
          @include('admin.partials.delete-form', ['index' => $apartment->id])
          <a href="{{route('admin.apartments.index')}}" class="btn btn-primary d-xsm-none"><i class="fa-solid fa-list"></i></a>
        </div>
    </div>



    <div class="d-flex block pb-5">

      {{-- LEFT-SIDE --}}

      {{-- BOX DELLA SPONSORIZZAZIONE VERSIONE MOBILE --}}
      <div class="box-card-long-show smaller mb-3 d-block d-sm-none">
        <div class="card-md-description d-flex justify-content-between align-items-center">
          <div class="visibility">
            @if ($apartment->is_visible)
              <h5>
                <i class="fa-regular fa-circle-check" style="color: #1ED760;"></i>
                Il tuo immobile è online
              </h5>
            @else
              <h5>
                <i class="fa-regular fa-circle-xmark" style="color: #DC3545;"></i>
                Il tuo immobile è offline
              </h5>
            @endif
          </div>
          {{-- STATO SPONSORIZZAZIONE --}}
          <div class="d-flex align-items-center justify-content-center">
            @if (!$apartment->is_visible)
              <h4>Pubblica il tuo annuncio per accedere alle Sponsorizzazioni</h4>
            @else
              <a href="{{route('admin.sponsorship', $apartment)}}" class="btn btn-primary my-3">
                @if ($sponsored_flag)
                  <span class="fs-6 text-light">Visualizza lo stato della tua sponsorizzazione</span>
                @else
                  <span class="fs-6 text-light">Sponsorizza il tuo appartamento</span>
                @endif
              </a>
            @endif
          </div>
        </div>
      </div>
      {{-- //////////////////// --}}
      <div class="left-side box-card-long-show smaller mb-3">

        <div class="box-image">
          <img src="{{asset('storage/' . $apartment->cover_image)}}" alt="">
        </div>

        <div class="description-box">
          <div class="price">
            <h4>Prezzo: {{$apartment->price}}€</h4>
            <h4>Metri quadrati: {{$apartment->square_meters}}m²
            </h4>
          </div>

          <div class="services d-flex gap-3">
            <h4>Servizi: </h4>
            <div class="badges">
              @forelse ($apartment->services as $service)
                <span class="badge rounded-pill text-bg-info">{{ $service->name }}</span>
              @empty
                <span>Nessun servizio disponibile per questo immobile</span>
              @endforelse
            </div>
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
        {{-- BOX DELLA SPONSORIZZAZIONE VERSIONE DESKTOP --}}
        <div class="box-card-long-show smaller d-none d-sm-block mb-5">
          <div class="card-md-description d-flex flex-column align-items-center justify-content-between align-items-center">
            <div class="visibility">
              @if ($apartment->is_visible)
                <h5>
                  <i class="fa-regular fa-circle-check" style="color: #1ED760;"></i>
                  Il tuo immobile è online
                </h5>
              @else
                <h5>
                  <i class="fa-regular fa-circle-xmark" style="color: #DC3545;"></i>
                  Il tuo immobile è offline
                </h5>
              @endif
            </div>
            {{-- STATO SPONSORIZZAZIONE --}}
            <div>
              @if (!$apartment->is_visible)
                <h4>Pubblica il tuo annuncio per accedere alle Sponsorizzazioni</h4>
              @else
                <a href="{{route('admin.sponsorship', $apartment)}}" class="btn btn-primary my-3">
                  @if ($sponsored_flag)
                    <span class="fs-6 text-light">Visualizza lo stato della tua sponsorizzazione</span>
                  @else
                    <span class="fs-6 text-light">Sponsorizza il tuo appartamento</span>
                  @endif
                </a>
              @endif
            </div>
          </div>
        </div>

        <div class="description-box box-card-long-show smaller">
          <i class="fa-solid fa-location-dot"></i>
          <span>{{$apartment->address}}</span>
          <span id="lat" hidden>{{ $lat }}</span>
          <span id="lng" hidden>{{ $lng }}</span>
          <div id="map" class="m-auto my-4" style="width: 400px; height: 300px"></div>
        </div>

      </div>

    </div>

  </div>

  <script type="text/javascript">
    /***** MAP SCRIPT *****/
    const lat = document.getElementById('lat').innerHTML;
    const lng = document.getElementById('lng').innerHTML;
    const apiKey = @php echo json_encode(env('API_IT_KEY'));  @endphp;

    // INSERT LONGITUDE AND LATITUDE
    let center= [lng, lat]
    const map = tt.map({
      key: apiKey,
      container: "map",
      center: center,
      zoom: 16
    })
    map.on('load', () =>{
      new tt.Marker().setLngLat(center).addTo(map)
    })

  </script>

@endsection




