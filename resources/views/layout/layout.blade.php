<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite(['resources/css/app.css','resources/js/app.js','resources/js/dropdown-init.js','resources/js/modal-init.js','resources/js/datatable-init.js'])
  @yield('styles')
</head>

<body>
   
    @include('layout.partials.navbar')

    @yield('content')

    @include('layout.partials.footer')

@stack('scripts')
</body>
</html>