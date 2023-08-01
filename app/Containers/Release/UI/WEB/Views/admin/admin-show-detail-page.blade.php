@extends('release::layouts.admin-layout')

@section('title', 'Create Release')

@section('css')
    <style>
        @include('release::admin.css.admin-main-css');
    </style>
    <style>
        @include('release::admin.css.admin-create-release-css');
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
@endsection


@section('php')
@endsection

@section('content')
<div class="content">
  
</div>

@endsection
