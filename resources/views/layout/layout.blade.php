<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RoadWatch San Juan City</title>
  <link rel="icon" type="image/x-icon" href="/images/logo-icon-no-bg.png">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  @vite(['resources/css/app.css','resources/js/app.js'])
  @if (Route::is('register'))
    @vite('resources/js/password-validation.js')
  @endif
  @if (Route::is('reports.show') || Route::is('reports.edit'))
    @vite('resources/js/image-handler.js')
  @endif
  @if (Route::is('reports.dashboard'))
    @vite('resources/js/radial-chart.js')
  @endif
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

  @yield('styles')
</head>

<body>
   
    @include('layout.partials.navbar')

    @yield('content')

    @include('layout.partials.footer')

    @stack('scripts')
</body>
</html>