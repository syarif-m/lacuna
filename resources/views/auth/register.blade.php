
@extends('layouts.app')

@section('title', 'Create Account | Lacuna')

@section('content')
<section class="auth-page">
    <div class="auth-card">

        <div class="auth-brand-panel">
            <a href="{{ route('home') }}" class="auth-logo">
                LACUNA
            </a>

            <div class="auth-brand-content">
                <span class="auth-eyebrow">JOIN THE COMMUNITY</span>
                <h1>Every mystery begins with a question.</h1>
                <p>
                    Become part of a community dedicated to
                    documenting the unknown and exploring new perspectives.
                </p>
            </div>

            <p class="auth-brand-footer">
                Explore the Unknown.
            </p>
        </div>

        <div class="auth-form-panel">
            <div class="auth-heading">
                <span class="auth-eyebrow">CREATE YOUR ACCOUNT</span>
                <h2>Join Lacuna.</h2>
                <p>Create an account to start contributing.</p>
            </div>

            @if ($errors->any())
                <div class="auth-error" role="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}"
                  class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Your full name"
                        autocomplete="name"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="Choose a username"
                        autocomplete="username"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="name@example.com"
                        autocomplete="email"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="At least 8 characters"
                        autocomplete="new-password"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password_confirmation">
                        Confirm Password
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Enter your password again"
                        autocomplete="new-password"
                        required
                    >
                </div>

                <button type="submit" class="auth-submit">
                    Create Account
                    <span aria-hidden="true">→</span>
                </button>
            </form>

            <div class="auth-switch">
                <span>Already have an account?</span>
                <a href="{{ route('login') }}">Sign in</a>
            </div>
        </div>

    </div>
</section>
@endsection
