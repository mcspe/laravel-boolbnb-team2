<header class="bg-dark">
  <nav>
      <div class="d-flex">
          <a class="" href="{{ route('admin.home')}}">
              BOOLB&B
          </a>


              <!-- Left Side Of Navbar -->
              <ul class="">
                  <li class="">
                      <a class="" target="_blank" href="#">Vai al sito pubblico</a>
                  </li>
              </ul>

              <!-- Right Side Of Navbar -->
              <ul class="navbar-nav ml-auto">
                  <!-- Authentication Links -->
                  @guest
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('login') }}">Login</a>
                          </li>
                      @if (Route::has('register'))
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('register') }}">Registrati</a>
                          </li>
                      @endif
                  @else
                      <li class="nav-item dropdown d-flex">

                          <span class="text-white me-2">{{ Auth::user()->name }}</span>

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" >
                              @csrf
                              <button class="btn btn-secondary" type="submit" title="logout"><i class="fa-solid fa-arrow-right-from-bracket"></i></button>
                          </form>

                      </li>
                  @endguest
              </ul>
          </div>
      </div>
  </nav>

</header>
