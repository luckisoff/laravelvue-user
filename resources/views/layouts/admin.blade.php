<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">


</head>
<body>
<div class="page-wrapper chiller-theme" id="app">
 @include('layouts.navbar')
  <!-- sidebar-wrapper  -->
  <main class="page-content">
    <div class="container-fluid">
        @yield('content')
      </div>
    </div>

  </main>
  <!-- page-content" -->
</div>

@auth
<script>
   window.user= <?php
        echo json_encode([
                "name"=>auth()->user()->name,
                "email"=>auth()->user()->email,
                "roles"=>auth()->user()->roles,
                "permissions"=>auth()->user()->getAllPermissions()
            ]);
        ?>
</script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/all.min.js') }}" ></script>
<script src="{{ asset('js/navbar.js') }}"></script>
@endauth

</body>

</html>
