<!DOCTYPE html>
<html>

<head>
    <title>Apiato</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">


    <style>
        html,
        body {
            background: url("https://www.google.com/url?sa=i&url=https%3A%2F%2Fpixabay.com%2Fimages%2Fsearch%2Fnature%2F&psig=AOvVaw16KG-R20lsPH_X8QyE7uAf&ust=1689992305532000&source=images&cd=vfe&opi=89978449&ved=0CA4QjRxqFwoTCKDC9onenoADFQAAAAAdAAAAABAD");
            height: 100%;
            /* background: #000; */
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
