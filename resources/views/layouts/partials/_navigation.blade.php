
<nav class="navbar">
    <div class="container">
        <div class="navbar-start">
            <div class="navbar-brand">
                <a href="{{ route('home') }}" class="nav-item is-brand">{{ config('app.name') }}</a>
                <span class="navbar-burger burger" data-target="navbarMenuHeroA">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </div>
        </div>
        <div id="navbarMenuHeroA" class="navbar-menu">
        <div class="navbar-end">
            @guest
                <a class="navbar-item" href="{{ route('login') }}">
                    Sign in
                </a>

                <div class="navbar-item">
                    <a class="button" href="{{ route('register') }}">
                        Start Selling
                    </a>
                </div>
            @else
                <a class="navbar-item" href="{{ route('account') }}">
                    Your Account
                </a>
                   
                @role('admin')

                    <div class="navbar-item has-dropdown is-hoverable has-text-white">
                        <a class="navbar-link" href="{{ route('admin.index') }}">
                            Admin
                        </a>
                
                        <div class="navbar-dropdown">
                            <a class="navbar-item" href="{{ route('users.list') }}">
                                Users List
                            </a>
                        </div>
                      </div>
                    </div>
                @endrole

                <a 
                class="navbar-item"  
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    Sign Out
                </a>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endguest
            
        </div>
        </div>
    </div>
</nav>

