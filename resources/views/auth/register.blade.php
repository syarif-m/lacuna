
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Lacuna</title>
</head>
<body>
    <h1>LACUNA</h1>
    <h2>Create an Account</h2>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('register.submit') }}">
        @csrf

        <label>Name</label>
        <input type="text" name="name"
               value="{{ old('name') }}" required>

        <label>Username</label>
        <input type="text" name="username"
               value="{{ old('username') }}" required>

        <label>Email</label>
        <input type="email" name="email"
               value="{{ old('email') }}" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit">Register</button>
    </form>

    <p>Already have an account?
        <a href="{{ route('login') }}">Login</a>
    </p>

    <a href="{{ route('home') }}">Back to Home</a>
</body>
</html>
