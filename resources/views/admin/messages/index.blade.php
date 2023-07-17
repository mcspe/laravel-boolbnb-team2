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
        <span>{{ Auth::user()->name }}, sono presenti X nuovi messaggi</span>
      </div>
    </div>

    <div class="size">
      <table class="table">

        <thead>
          <tr>
            <th scope="col">Mittente</th>
            <th scope="col">Email</th>
            <th scope="col">Messaggio</th>
            <th scope="col">Azioni</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($messages as $message)
              <tr>
                <td>{{$message->sender_name . ' ' . $message->sender_lastname}}</td>
                <td>{{$message->sender_email}}</td>
                <td>{{$message->text}}</td>
                <td>
                  <a href="{{route('admin.messages.show', $message)}}" class="btn btn-primary">Vai</a>
                  <a href="{{route('admin.messages.destroy', $message)}}" class="btn btn-danger">Elimina</a>
                </td>
              </tr>
          @endforeach
        </tbody>

      </table>
    </div>

  </div>
@endsection
