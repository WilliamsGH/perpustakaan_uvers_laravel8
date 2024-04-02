<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ($title) ? "$title | PERPUSTAKAAN UVERS" : "PERPUSTAKAAN UVERS"}}</title>

    {{-- CSS --}}
    <link href="{{ Asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ Asset('css/addedCSS.css') }}" rel="stylesheet" />
    @yield('css')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />


</head>
<body>

    <div class="wrapper">
        @yield('main')
    </div>

  <!-- Script -->
  <script src="{{ Asset('js/app.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  @yield('js')
  <!-- End Script -->

</body>
</html>