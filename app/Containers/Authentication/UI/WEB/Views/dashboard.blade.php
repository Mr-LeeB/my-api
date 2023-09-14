<!DOCTYPE html>
<html>

<head>
    <title>Apiato</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">


    <style>
        html,
        body {
            height: 100%;
            background: #6471a7;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            font-weight: 100;
            font-family: 'Lato';
            background-size: cover;
            color: #000;
        }

        .container {
            text-align: center;
            vertical-align: middle;
        }

        .content {

            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
            margin-bottom: 40px;
            color: #000;
        }

        .name {
            font-size: 96px;
            margin-bottom: 40px;
            color: #000;
            font-weight: bold;
        }

        a {
            text-decoration: none;
        }
    </style>

</head>

@php
    $user = Auth::user();
@endphp

<body>
    @include('product::menu')
    <div class="container">
        <div class="content">
            <div class="title"> Hi
                <div class="name"> {{ $user->name }}</div>
            </div>
        </div>
    </div>
</body>

</html>
