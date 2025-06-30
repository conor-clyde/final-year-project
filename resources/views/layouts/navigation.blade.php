<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <x-application-logo class="h-9 w-auto" />
        </a>

        <!-- Navigation Links -->
        <div class="navbar-nav me-auto">
            <a class="nav-link" href="{{ route('dashboard') }}">
                {{ __('Dashboard') }}
            </a>
            
            @auth
                @if(auth()->user()->role >= 2)
                    <!-- Library Management Dropdown -->
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('Library Management') }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('book.index') }}">{{ __('Books') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('author.index') }}">{{ __('Authors') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('publisher.index') }}">{{ __('Publishers') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('genre.index') }}">{{ __('Genres') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('loan.index') }}">{{ __('Loans') }}</a></li>
                        </ul>
                    </div>
                @endif
                
                @if(auth()->user()->role == 3)
                    <!-- Admin Dropdown -->
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('Admin') }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('user.index') }}">{{ __('Users') }}</a></li>
                        </ul>
                    </div>
                @endif
            @endauth
        </div>

        <!-- Settings Dropdown -->
        @auth
            <div class="navbar-nav">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name ?? 'User' }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        @else
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                @if (Route::has('register'))
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                @endif
            </div>
        @endauth
    </div>
</nav>
