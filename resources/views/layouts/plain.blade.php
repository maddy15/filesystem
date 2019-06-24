<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   @include('layouts/partials/_head')
</head>
<body>
    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
