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
    <script>
        function confirmCreateRelease() {
            var name = $('#name').val();
            var title_description = $('#title_description').val();
            var detail_description = $('#detail_description').val();
            var date_created = $('#date_created').val();
            var img = $('#file_upload').files;

            console.log(img);
            if (name < 3 || name > 40) {
                alert('Name must be between 3 and 40 characters!');
                return;
            }

            if (title_description < 3 || title_description > 255) {
                alert('Title must be between 3 and 40 characters!');
                return;
            }

            if (detail_description < 3 || detail_description > 4096) {
                alert('Description must be between 3 and 40 characters!');
                return;
            }

            if (date_created == '') {
                alert('Date Created must be not empty!');
                return;
            }

            if (img == null) {
                $('#file_upload').removeAttr('name');
            }

            $('#form-create-release').submit();
        }

        $(document).ready(function() {
            $(".btn-add-image").click(function() {
                $('#file_upload').trigger('click');
            });

            $('.list-input-hidden-upload').on('change', '#file_upload', function(event) {
                for (let i = 0; i < event.target.files.length; i++) {
                    let today = new Date();
                    let time = today.getTime();
                    let image = event.target.files[i];
                    let file_name = event.target.files[i].name;
                    let box_image = $('<div class="box-image"></div>');
                    box_image.append('<img src="' + URL.createObjectURL(image) + '" class="picture-box">');
                    box_image.append('<div class="wrap-btn-delete"><span data-id=' + time +
                        ' class="btn-delete-image">x</span></div>');
                    $(".list-images").append(box_image);

                    let input_type_file =
                        '<input type="file" name="images[]" id="file_upload" class="hidden" multiple>';
                    $('.list-input-hidden-upload').append(input_type_file);

                    $('#file_upload').attr('id', time);
                }
            });


            $(".list-images").on('click', '.btn-delete-image', function() {
                let id = $(this).data('id');
                $('#' + id).remove();
                $(this).parents('.box-image').remove();
            });
        });
    </script>
@endsection

@section('php')

@endsection


@section('content')
    {{ $errors }}
    <div class="content">
        <div class="create-content">
            <div class="create-release">
                <h2>Create new release</h2>
                <form id="form-create-release" class="form-create" action="{{ route('web_release_store') }}" method="POST"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="text" id="name" name="name" placeholder="Name">
                    @if ($errors->has('name'))
                        <span style="color:red">{{ $errors->first('name') }} </span>
                    @endif

                    <input type="text" id="title_description" name="title_description" placeholder="Title">
                    @if ($errors->has('title_description'))
                        <span style="color:red">{{ $errors->first('title_description') }} </span>
                    @endif

                    <textarea type="text" id="detail_description" name="detail_description" placeholder="Description"></textarea>
                    @if ($errors->has('detail_description'))
                        <span style="color:red">{{ $errors->first('detail_description') }} </span>
                    @endif

                    <input type="date" id="date_created" name="date_created" placeholder="Date Created"
                        value="{{ date('Y-m-d') }}">
                    @if ($errors->has('date_created'))
                        <span style="color:red">{{ $errors->first('date_created') }} </span>
                    @endif

                    <div class="is-publish-checkbox">
                        <input type="checkbox" name="is_publish" id="is_publish">
                        <label for="is_publish"> Is Publish</label>
                    </div>
                    <div>
                        <div class="list-input-hidden-upload">
                            <input type="file" name="images[]" id="file_upload" class="hidden" multiple>
                        </div>
                        <button class="btn-add-image" type="button">
                            <i class="fa fa-plus" style="margin-right: 4px"> </i> Add images</button>
                        @if ($errors->has('images'))
                            <span style="color:red">{{ $errors->first('images') }} </span>
                        @endif
                    </div>
                    <div class="list-images"></div>
                    <input type="button" onclick="confirmCreateRelease()" value="Create new release">
                </form>
            </div>
            <div class="info-release-created-recently">
                @if (session('success'))
                    <h2 style="color:blue">Create Success!!</h2>

                    {{-- show release created recently --}}

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
