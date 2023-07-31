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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script></script>
@endsection

@section('php')

@endsection


@section('content')
    <div class="content">
        {{ $errors }}
        <div class="create-content">
            <div class="create-release">
                <h2>Create new release</h2>
                <form id="form-create-release" class="form-create" action="{{ route('web_release_store') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="text" id="name" name="name" placeholder="Name">
                    <input type="text" id="title_description" name="title_description" placeholder="Title">
                    <textarea type="text" id="detail_description" name="detail_description" placeholder="Description"></textarea>
                    <input type="date" id="date_created" name="date_created" placeholder="Date Created"
                        value="{{ date('Y-m-d') }}">
                    <div class="is-publish-checkbox">
                        <input type="checkbox" name="is_publish" id="is_publish">
                        <label for="is_publish"> Is Publish</label>
                    </div>
                    <input type="submit" value="Create new release">
                </form>
            </div>
            <div class="info-release-created-recently">
                @if (session('success'))
                    <h2 style="color:blue">Create Success!!</h2>
                    @php
                        echo html_entity_decode(session('success'));
                    @endphp
                @else
                    <h2>Don't have Release(s) created recently!</h2>
                @endif
            </div>
        </div>
    </div>
@endsection
