
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Lacuna</title>
</head>
<body>
    <h1>LACUNA</h1>
    <h2>Login</h2>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        <label>Email or Username</label>
        <input type="text" name="identity"
               value="{{ old('identity') }}" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>
            <input type="checkbox" name="remember" value="1">
            Remember me
        </label>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account?
        <a href="{{ route('register') }}">Register</a>
    </p>

    <a href="{{ route('home') }}">Back to Home</a>
</body>
</html>
