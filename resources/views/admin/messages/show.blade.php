@extends('layouts.admin')

@section('title')
  | Message
@endsection

@section('content')

@section("jumbotron-title")
Messaggio
@endsection

@section("jumbotron-subtitle")
Dettaglio messaggio
@endsection

<div class="container">

  <div class="box-card-long mb-5 d-flex justify-content-between align-items-center">
    <span>Hai un nuovo messaggio da <span class="fw-bold">{{ $message->sender_name }}</span></span>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal">
      <i class="fa-solid fa-trash"></i>
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h2 class="modal-title fs-5 text-danger fw-bold" id="exampleModalLabel">Attenzione!</h2>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Il messaggio verrà <span class="text-danger">eliminato</span>, sei sicuro?
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Annulla</button>
                  <form
                      action="{{ route('admin.messages.destroy', $message) }}"
                      method="POST"
                      class="d-inline"
                  >
                      @csrf
                      @method('DELETE')

                      <button type="submit" class="btn btn-danger fw-bold">
                          Elimina
                      </button>

                  </form>
              </div>
          </div>
      </div>
    </div>
  </div>

  <div class="box-card-long mb-5">
    <div class="size">
      <h4>Mittente: {{ $message->sender_name . ' ' . $message->sender_lastname }}</h4>
      <h6>{{ $message->sender_email }}</h6>
      <p>{{ $message->text }}</p>
    </div>
  </div>

</div>


@endsection
