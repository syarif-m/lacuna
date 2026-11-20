
<nav class="navbar">
    <a href="{{ route('home') }}" class="navbar-logo">
        LACUNA
    </a>

    <div class="navbar-links">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('discover') }}">Discover</a>
        <a href="{{ route('about') }}">About</a>
    </div>

    <div class="navbar-account">
        @guest
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @else
            @if (auth()->user()->role === 'ADMIN')
                <a href="{{ route('admin.dashboard') }}">
                    Admin Dashboard
                </a>
            @else
                <a href="{{ route('member.dashboard') }}">
                    Your Dashboard
                </a>
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @endguest
    </div>
</nav>
