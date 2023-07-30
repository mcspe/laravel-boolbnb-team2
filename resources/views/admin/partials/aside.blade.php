<aside class="">
  <div class="aside-wrapper d-flex flex-column justify-content-between h-100 w-100">
    <nav>
        <ul>
            <li><a href="{{ route('admin.home') }}"><img src="/logo.png" alt=""></a></li>
            <li><a href="{{ route('admin.home') }}" class="{{Route::currentRouteName()=== "admin.home" ? "active" : ""}}"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li><a href="{{route("admin.apartments.create")}}" class="{{Route::currentRouteName()=== "admin.apartments.create" ? "active" : ""}}"><i class="fa-solid fa-square-plus"></i> Aggiungi Appartamento</a></li>
            <li><a href="{{route("admin.apartments.index")}}" class="{{Route::currentRouteName()=== "admin.apartments.index" ? "active" : ""}}"><i class="fa-solid fa-list"></i> Elenco Appartamenti</a></li>
            <li><a href="{{route('admin.messages.index')}}" class="{{Route::currentRouteName()=== "admin.messages.index" ? "active" : ""}}"><i class="fa-solid fa-inbox"></i> Messaggi</a></li>
            <li><a href="http://localhost:5174/"><i class="fa-solid fa-globe"></i>Visita il sito pubblico</a></li>
          </ul>
      </nav>
      <div class="line d-flex flex justify-content-center align-items-center mb-4">
        <span class="text-light me-3"><i class="fa-regular fa-user me-2"></i>{{ Auth::user()->name }}</span>

        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-danger" type="submit" title="logout"><i class="fa-solid fa-arrow-right-from-bracket"></i></button>
        </form>
      </div>
  </div>

</aside>
