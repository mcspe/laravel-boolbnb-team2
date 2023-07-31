@extends('layouts.admin')

@section('title')
  | Inbox
@endsection

@section('content')

@section("jumbotron-title")
Messaggi
@endsection

@section("jumbotron-subtitle")
Controlla i messaggi ricevuti
@endsection

  <div class="container">

    <div class="box-card-long mb-5 ">
      <div class="card-md-description d-flex justify-content-between">
        @if ($n_messages)
          <span>
            Ciao {{ Auth::user()->name }}, hai {{ $n_messages }}
            @if ($n_messages > 1)
              messaggi
            @else
              messaggio
            @endif
            nella tua bacheca
          </span>
        @else
          <span>Ciao {{ Auth::user()->name }}, al momento non sono presenti messaggi nella tua bacheca</span>
        @endif

      </div>
    </div>

    <div class="box-card-long mb-5">
      <div class="size">
        @if ($n_messages)
          <table class="table">

            <thead>
              <tr>
                <th scope="col">Mittente</th>

                {{-- <th scope="col" class="d-xsm-none">Email</th> --}}
                <th scope="col" class="d-xsm-none">Messaggio</th>

                {{-- <th scope="col">Email</th> --}}
                <th scope="col">Appartamento</th>

                <th scope="col">Azioni</th>
              </tr>
            </thead>

            <tbody>
              @foreach ($apartments as $apartment)
                @foreach ($apartment->messages as $message)
                  <tr>
                    <td>{{$message->sender_name . ' ' . $message->sender_lastname}}</td>

                    {{-- <td class="d-xsm-none">{{$message->sender_email}}</td> --}}
                    <td class="d-xsm-none">{{$message->text}}</td>

                    {{-- <td>{{$message->sender_email}}</td> --}}
                    <td>{{$apartment->title}}</td>

                    <td>
                      <a href="{{route('admin.messages.show', $message)}}" class="btn btn-primary"><i class="fa-solid fa-eye"></i></a>
                    </td>
                  </tr>
                @endforeach
              @endforeach
            </tbody>

          </table>
        @else
          @if (count($apartments))
            <h3>Sponsorizza i tuoi appartamenti per ottenere maggiore visibilità!</h3>
            <p>La nostra sezione <strong>In Evidenza</strong> è accessibile tramite l'acquisto di uno fra i 3 pacchetti di sponsorizzazione disponibili.</p>
            <a href="{{route('admin.apartments.index')}}" class="btn btn-primary m-3">Vai ai tuoi appartamenti</a>
          @else
            <h3>Aggiungi un appartamento e comincia a ricevere messaggi.</h3>
            <p>Per una maggiore visibilità puoi acquistare uno dei nostri pacchetti di sponsorizzazione che ti permetteranno di avere il tuo appartamento nella nostra sezione <strong>In Evidenza</strong>!</p>
            <a href="{{route('admin.apartments.create')}}" class="btn btn-primary m-3">Aggiungi un appartamento</a>
          @endif
        @endif
      </div>
    </div>

  </div>
@endsection
