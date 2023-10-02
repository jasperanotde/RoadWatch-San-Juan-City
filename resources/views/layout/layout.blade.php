<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  @vite(['resources/css/app.css','resources/js/app.js'])
  @if (Route::is('reports.show') || Route::is('reports.edit'))
    @vite('resources/js/image-handler.js')
  @endif

  
  @yield('styles')
</head>

<body>
   
    @include('layout.partials.navbar')

    @yield('content')

    @include('layout.partials.footer')

    @stack('scripts')
</body>
</html>