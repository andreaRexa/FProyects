<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FProjects</title>
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" href="{{ asset('iconoApp16.ico') }}" type="image/x-icon">
    <style>
        body {
            background-image: url('/storage/imagenes/fondo.jpg');
            background-size: cover; 
            background-repeat: no-repeat;
            background-position: center; 
        }
    </style>
</head>
<body> 
    <div id="app">
        @if(session()->has('user'))
            <menu-bar :user-role="{{ session('user.rol') }}"></menu-bar>
        @else
            <menu-bar :user-role="0"></menu-bar>
        @endif
    </div>
    <div>
        @yield('content')
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html> 