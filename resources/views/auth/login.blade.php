
@extends('layouts.app')

@section('title', 'Login | Lacuna')

@section('content')
<section class="auth-page">
    <div class="auth-card">

        <div class="auth-brand-panel">
            <a href="{{ route('home') }}" class="auth-logo">
                LACUNA
            </a>

            <div class="auth-brand-content">
                <span class="auth-eyebrow">A COMMUNITY KNOWLEDGE ARCHIVE</span>
                <h1>Explore the Unknown.</h1>
                <p>
                Stories, evidence, theories, and explanations beyond the known.
                </p>
            </div>

            <p class="auth-brand-footer">
                A community-driven archive for mysteries, evidence, theories, and explanations.
            </p>
        </div>

        <div class="auth-form-panel">
            <div class="auth-heading">
                <span class="auth-eyebrow">MEMBER ACCESS</span>
                <h2>Welcome back.</h2>
                <p>Sign in to continue exploring Lacuna.</p>
            </div>

            @if ($errors->any())
                <div class="auth-error" role="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}"
                  class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="identity">Username or Email</label>
                    <input
                        type="text"
                        id="identity"
                        name="identity"
                        value="{{ old('identity') }}"
                        placeholder="Enter your username or email"
                        autocomplete="username"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <label class="auth-checkbox">
                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                        @checked(old('remember'))
                    >
                    <span>Remember me</span>
                </label>

                <button type="submit" class="auth-submit">
                    Sign In
                    <span aria-hidden="true">→</span>
                </button>
            </form>

            <div class="auth-switch">
                <span>Don't have an account?</span>
                <a href="{{ route('register') }}">Create an account</a>
            </div>
        </div>

    </div>
</section>
@endsection
