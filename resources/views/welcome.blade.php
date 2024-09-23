@extends('layouts.master')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="text-center">
        <h1 class="mb-4">Bienvenue à ORMVA</h1>

        @if (Route::has('login'))
            <div class="d-flex justify-content-center">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary rounded-pill py-3 px-4 me-2">
                        Dashboarde
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary rounded-pill py-3 px-4 me-2">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-secondary rounded-pill py-3 px-4 ms-2">
                            Register
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</div>
@endsection
