<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- @vite(['resources/css/app.css','resources/js/app.js','resources/js/dropdown-init.js','resources/js/modal-init.js','resources/js/datatable-init.js']) -->
  @vite(['resources/css/app.css','resources/js/app.js','resources/js/dropdown-init.js','resources/js/modal-init.js'])
  
  @yield('styles')

  <!-- Include Fancybox CSS -->
  <link rel="stylesheet" href="{{ asset('node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.css') }}">

  <!-- Include Fancybox JavaScript -->
<script src="{{ asset('js/app.js') }}"></script>

</head>

<body>
   
    @include('layout.partials.navbar')

    @yield('content')

    @include('layout.partials.footer')

@stack('scripts')
</body>
</html>