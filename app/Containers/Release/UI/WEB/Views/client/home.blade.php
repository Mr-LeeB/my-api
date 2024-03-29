@extends('release::client.list-all-release')

@section('css')
    <style>
        @include('release::client.main-css');
    </style>
@endsection


@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function activeBody(id) {
            $('#body' + id).toggleClass('unactive');
        }
    </script>
@endsection
