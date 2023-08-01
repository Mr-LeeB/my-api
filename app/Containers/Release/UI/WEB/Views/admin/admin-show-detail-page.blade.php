@extends('release::layouts.admin-layout')

@section('title', 'Create Release')

@section('css')
    <style>
        @include('release::admin.css.admin-main-css');
    </style>
    <style>
        @include('release::admin.css.admin-show-detail-css');
    </style>
@endsection

@section('header')
    @parent
    @include('release::header.header')
@endsection

@section('menu')
    @parent
    @include('release::menu.menu')
@endsection

@section('footer')
    @parent
    @include('release::footer.footer')
@endsection


@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('.image').click(function() {
                var src = $(this).attr('src');
                $('.image').removeClass('active');
                $(this).addClass('active');
                $('#image').attr('src', src);
            });

            var src = $('.image').attr('src');
            $('#image').attr('src', src);
        });
    </script>
@endsection


@section('php')
    @php

    @endphp
@endsection

@section('content')
    <div class="content">
        <div class="image-container">
            <div class="image-title">
                <h1>Images</h1>
            </div>

            <img src="" alt="name" id="image" width="400px">

            <div class="scroll-container">
                @if ($release->images != null)
                    @foreach ($release->images as $image)
                        <img src="{{ asset($image) }}" alt="name" class="image" width="80px">
                    @endforeach
                @endif
            </div>
        </div>
        <div class="content-container">
            <div class="content-name">
                <h1>{{ $release->name }}</h1>
            </div>
            <div class="content-title-description">
                <p> <strong>Title: </strong> {{ $release->title_description }}</p>
                <p><strong>Description: </strong><br />{{ $release->detail_description }}</p>
            </div>
            <div class="content-date">
                <p> <strong>Date Created: </strong> {{ $release->date_created }}</p>
            </div>
        </div>
    </div>
@endsection
