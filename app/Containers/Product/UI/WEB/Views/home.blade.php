@extends('product::products-list')

@section('css')
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Roboto', sans-serif;
            font-weight: 100;
            height: 100%;
            margin: 0;
        }

        .parent {

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        .content {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            width: 60%;
            border-radius: 5px;
            height: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
            font-size: 18px;
        }

        table th,
        table td {
            text-align: left;
            padding: 16px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        tr:hover {
            background-color: #ddd;
        }

        th {
            background-color: #9b2d2d;
            color: white;
        }

        .btn-create {
            background-color: #9b2d2d;
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .btn-create:hover {
            background-color: #7a1f1f;
        }

        .create-new-product {
            width: 20%;
        }

        img {
            border-radius: 5px;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script></script>
@endsection
