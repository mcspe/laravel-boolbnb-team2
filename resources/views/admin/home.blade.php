@extends('layouts.admin')

@section('title')
  | Dashboard
@endsection

@section('content')


@section("jumbotron-title")
ciao {{ Auth::user()->name }}! <i class="fa-solid fa-hand fa-shake" style="color: #ffd500;"></i>
@endsection

@section("jumbotron-subtitle")
Qui sono presenti tutte le statistiche della tua attività.
@endsection

  <div class="d-flex justify-content-center gap-5">

    {{-- 1 --}}
    <a href="{{route("admin.apartments.index")}}">
      <div class="box-card d-flex">
          <div class="circle-img text-center green">
            <i class="fa-solid fa-house-user"></i>
          </div>
          <div class="card-md-description d-flex flex-column">
            <span>Appartamenti</span>
            <span>{{$n_apartments}}</span>
          </div>
      </div>
    </a>

    {{-- 2 --}}
    <a href="#">
      <div class="box-card d-flex">
        <div class="circle-img text-center blue">
          <i class="fa-solid fa-list-ol"></i>
        </div>
        <div class="card-md-description d-flex flex-column">
          <span>Elenco Appartamenti</span>
          <span>99</span>
        </div>
      </div>
    </a>

    {{-- 3 --}}
    <a href="#">
      <div class="box-card d-flex">
        <div class="circle-img text-center orange">
          <i class="fa-solid fa-signal"></i>
        </div>
        <div class="card-md-description d-flex flex-column">
          <span>Visite</span>
          <span>126,000</span>
        </div>
      </div>
    </a>

  </div>

  <div class="container mb-5 mt-5 d-flex justify-content-center">
   <div style="width: 700px; height: 500px"><canvas id="myChart"></canvas></div>
  </div>

</div>


<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Red', 'Blue', 'Yellow',],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3,],
        borderWidth: 1
      }]
    },
    options: {
      plugins:{
        title:{
          display : true,
          align: 'center',
          text : "Grafico Appartamenti",
          font: {
            size:20
          }
        }

      }
    },
  });
</script>
  @endsection






