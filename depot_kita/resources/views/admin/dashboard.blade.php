<!DOCTYPE html>
<html lang="en">

@extends('admin/admin_navbar')

@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>

<body>
    <!-- Full-page container with background image -->
    <div class="container-fluid position-relative" 
         style="background: url('{{ asset('asset/food.jpg') }}') no-repeat center center / cover; 
                height: 100vh; 
                padding: 20px;">

        <!-- Semi-transparent overlay -->
        <div class="position-absolute" 
             style="background: rgba(255, 255, 255, 0.5); 
                    top: 0; 
                    left: 0; 
                    width: 100%; 
                    height: 100%; 
                    pointer-events: none;">
        </div>

        <!-- Main Content -->
        <div class="container-fluid position-relative" style="z-index: 1; padding-top: 50px;">
            <h1>Hello, {{$user->name}}!</h1>
            <p>Dashboard Overview</p>

            <div class="row">
                <!-- Dashboard Content Here -->
            </div>
        </div>
    </div>
</body>

</html>

@endsection
