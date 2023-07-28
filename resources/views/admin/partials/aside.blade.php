<aside class="">
  <nav>
      <ul>
          <li><a href="{{ route('admin.home') }}"><img src="/logo.png" alt=""></a></li>
          <li><a href="{{ route('admin.home') }}" class="{{Route::currentRouteName()=== "admin.home" ? "active" : ""}}"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
          <li><a href="{{route("admin.apartments.create")}}" class="{{Route::currentRouteName()=== "admin.apartments.create" ? "active" : ""}}"><i class="fa-solid fa-square-plus"></i> Aggiungi Appartamento</a></li>
          <li><a href="{{route("admin.apartments.index")}}" class="{{Route::currentRouteName()=== "admin.apartments.index" ? "active" : ""}}"><i class="fa-solid fa-list"></i> Elenco Appartamenti</a></li>
          <li><a href="{{route('admin.messages.index')}}" class="{{Route::currentRouteName()=== "admin.messages.index" ? "active" : ""}}"><i class="fa-solid fa-inbox"></i> Inbox</a></li>
          <li><a href="http://localhost:5174/"><i class="fa-solid fa-globe"></i>Visita il sito pubblico</a></li>

          <div class="line"></div>


          <li class="nav-item dropdown d-flex">

            <span class=""><i class="fa-regular fa-user"></i>{{ Auth::user()->name }}</span>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" >
                @csrf
                <button class="btn btn-danger" type="submit" title="logout"><i class="fa-solid fa-arrow-right-from-bracket"></i></button>
            </form>

        </li>
      </ul>
  </nav>

  </aside>
