<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   @include('layouts/partials/_head')
   @yield('styles')
  
</head>
<body>
    <div id="app">
        @include('layouts/partials/_navigation')
        @yield('content')
    </div>

    @include('layouts/partials/_scripts') 
    @yield('scripts')
    
    
</body>

</html>