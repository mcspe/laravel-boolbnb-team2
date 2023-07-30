<footer>
  <div class="links">

    <div class="link">

        <a href="{{ route('admin.home') }}" class="{{Route::currentRouteName()=== "admin.home" ? "active" : ""}}"><i class="fa-solid fa-chart-line"></i>Dashboard</a>
    </div>

    <div class="link">

      <a href="{{route("admin.apartments.index")}}" class="{{Route::currentRouteName()=== "admin.apartments.index" ? "active" : ""}}"><i class="fa-solid fa-list"></i>Lista immobili</a>
    </div>

    <div class="link">
      <a href="{{route("admin.apartments.create")}}" class="{{Route::currentRouteName()=== "admin.apartments.create" ? "active" : ""}}"><i class="fa-solid fa-square-plus"></i>Aggiungi immobile</a>
    </div>

    <div class="link">
      <a href="{{route('admin.messages.index')}}" class="{{Route::currentRouteName()=== "admin.messages.index" ? "active" : ""}}"><i class="fa-solid fa-inbox"></i>Messaggi</a>
    </div>
  </div>
</footer>
