<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Daily Life Assistant')</title>

    <!-- Load global CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    @stack('styles')
</head>
<body>
    
    <div class="container" style="display:flex; height:100vh;">
        <aside class="sidebar">
            <div class="logo-container">
                <h1>Daily Life Assistant</h1>
            </div>
            <nav class="sidebar-menu">
                <ul>
                    <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                        <a href="{{ url('dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    </li>
                    <li class="{{ request()->is('todos*') ? 'active' : '' }}">
                        <a href="{{ url('todos') }}"><i class="fas fa-list-check"></i> To-Do List</a>
                    </li>
                    <li class="{{ request()->is('mood') ? 'active' : '' }}">
                        <a href="{{ url('mood') }}"><i class="fas fa-face-smile"></i> Mood Tracker</a>
                    </li>
                    <li class="{{ request()->is('financial') ? 'active' : '' }}">
                        <a href="{{ url('financial') }}"><i class="fas fa-wallet"></i> Financial Tracker</a>
                    </li>
                    <li class="{{ request()->is('daily') ? 'active' : '' }}">
                        <a href="{{ url('daily') }}"><i class="fas fa-quote-left"></i> Daily Quote</a>
                    </li>
                    <li class="{{ request()->is('selfcare') ? 'active' : '' }}">
                        <a href="{{ url('selfcare') }}"><i class="fas fa-heart"></i> Self-Care</a>
                    </li>
                    <li class="{{ request()->is('profile') ? 'active' : '' }}">
                        <a href="{{ url('profile/1') }}"><i class="fas fa-user"></i> Profil</a>
                    </li>
                </ul>
            </nav>
            <div class="logout">
                <a href="#" id="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </aside>

        <main class="main-content">
            @yield('content')
        </main>
    </div>

    {{-- Modal Logout --}}
    <div class="modal" id="logout-modal" style="display:none;">
        <div class="modal-content">
            <p>Are you sure you want to logout?</p>
            <button id="confirm-logout" class="btn btn-danger">Logout</button>
            <button id="cancel-logout" class="btn btn-secondary">Cancel</button>
        </div>
    </div>

    <!-- Logout modal script -->
    <script>
        document.getElementById('logout-button').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('logout-modal').style.display = 'flex';
        });
        document.getElementById('cancel-logout').addEventListener('click', function() {
            document.getElementById('logout-modal').style.display = 'none';
        });
        
        document.getElementById('confirm-logout').addEventListener('click', function() {
        document.getElementById('logout-form').submit();
        });

        window.addEventListener('click', function(e) {
            if(e.target == document.getElementById('logout-modal')) {
                document.getElementById('logout-modal').style.display = 'none';
            }
        });
    </script>

    @stack('scripts')

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

</body>
</html>
