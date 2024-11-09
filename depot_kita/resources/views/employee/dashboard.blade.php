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
    <div class="container my-5">
        <h1>Hello, {{$user->name}}!</h1>


        <div class="row">
            <!-- Dashboard Content Here -->
        </div>
    </div>
</body>

</html>


@endsection