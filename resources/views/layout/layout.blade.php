<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <!-- @vite(['resources/css/app.css','resources/js/app.js','resources/js/dropdown-init.js','resources/js/modal-init.js','resources/js/datatable-init.js']) -->
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