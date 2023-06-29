<?php
use Illuminate\Support\Facades\Auth;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- CSS Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Additional CSS files -->
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3>@yield('title')</h3>
        <ul>
            <!-- Common Sidebar Links -->
            <li><a href="#">Dashboard</a></li>
            @auth
            @dd(Auth::user()->userType->usertype);
                    <!-- Developer Links -->
                @if(Auth::user()->userType->usertype === 'DEVELOPER')
                    <li><a href="#">Developer Link 1</a></li>
                    <li><a href="#">Developer Link 2</a></li>
                @elseif(Auth::user()->userType->usertype === 'ACCOUNTS')
                    <!-- Accounts Links -->
                    <li><a href="#">Accounts Link 1</a></li>
                    <li><a href="#">Accounts Link 2</a></li>
                @elseif(Auth::user()->userType->usertype === 'ENTRY CLERK')
                    <!-- Entry Clerk Links -->
                    <li><a href="#">Entry Clerk Link 1</a></li>
                    <li><a href="#">Entry Clerk Link 2</a></li>
                @elseif(Auth::user()->userType->usertype === 'SYSTEM ADMINISTRATOR')
                    <!-- System Administrator Links -->
                    <li><a href="#">System Administrator Link 1</a></li>
                    <li><a href="#">System Administrator Link 2</a></li>
                @elseif(Auth::user()->userType->usertype === 'MEMBER USER')
                    <!-- Member User Links -->
                    <li><a href="#">Member User Link 1</a></li>
                    <li><a href="#">Member User Link 2</a></li>
                @endif
            @endauth
            

            <li><a href="#">Profile</a></li>
            <li><a href="#">Logout</a></li>            
        </ul>
    </div>

    <!-- Content -->
    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <!-- Navbar content -->
                <a class="navbar-brand" href="#">Admin Panel</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                       
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-4">
            @yield('content')
        </div>
    </div>

    <!-- JavaScript files -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Additional JavaScript files -->
    @yield('scripts')
</body>
</html>
