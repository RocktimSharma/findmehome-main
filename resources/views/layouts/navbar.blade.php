
<nav class="navbar navbar-expand-md shadow-sm sticky-top"> <div class="container"> <a
      class="navbar-brand text-white fw-bold" href="{{ url('/') }}"> {{ config('app.name', 'Find Me Home') }} </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}"> <span
      class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent"> <ul class="navbar-nav me-auto"> <li
      class="nav-item"> 
      <a class="btn btn-outline-light fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal"
      aria-current="page" href="#">Location</a>
     </li> </ul>
      <ul class="navbar-nav ms-auto"> <!-- Authentication Links --> 
      @guest @if (Route::has('login')) 
        <li class="nav-item"> <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
        </li>  
        @endif @if (Route::has('register'))
         <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
        </li>
        @endif @else
        <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button"
        data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false" v-pre>
        {{ Auth::user()->name }}
        </a>

        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
       

        <a class="dropdown-item">
        {{ __('Account') }}
        </a>
        <a class="dropdown-item">
        {{ __('Wishlist') }}
        </a>
        <a href="{{ route('myPgs') }}" class="dropdown-item">
        {{ __('Your PGs') }}
        </a>
        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
        {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
    </div>
    </li>
    @endguest
    </ul>
</div>
</div>
</nav>


