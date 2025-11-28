<header>
    <nav class="glass-nav">
        <div class="nav-title">
            {{ $title ?? 'My Application' }}
        </div>

        <ul class="nav-links">
            <li><a href="{{ route('home') }}">Home</a></li>
            
            @guest
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
            @else
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </li>
            @endguest
        </ul>
    </nav>
</header>