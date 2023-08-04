@extends('release::layouts.admin-layout')

@section('title', 'Create Release')

@section('css')
    <style>
        @include('release::admin.css.admin-main-css');
    </style>
    <style>
        @include('release::admin.css.admin-show-detail-css');
    </style>
    <style>
        @include('release::admin.css.admin-edit-release-css');
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
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        header: [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    ['image', 'code-block']
                ]
            },

        });
        let detail_description = '{{ detail_description($release->detail_description) }}';
        quill.setContents([{
            insert: detail_description,
        }]);

        $(".ql-editor").attr('id', 'detail_description_editor');



        $("#form-update-release").on("submit", function() {
            // put data from quill editor into input
            $("#detail_description").val($(".ql-editor").html());
        })
    </script>

    <script>
        // Function to calculate and set the input width based on its value
        function adjustInputWidth(input) {
            // Create a hidden temporary element to calculate the width of the input value
            var tempElement = $('<span>').css({
                'font-size': $(input).css('font-size'),
                'font-family': $(input).css('font-family'),
                'white-space': 'pre'
            }).text($(input).val());

            // Append the temporary element to the body so it gets rendered
            $('body').append(tempElement);

            // Get the width of the temporary element
            var width = tempElement.width();

            // Remove the temporary element
            tempElement.remove();

            // Set the input width (add some extra pixels to account for padding and border if needed)
            $(input).css('width', width + 25); // Adjust the value of 25 as needed
        }

        function adjustTextareaHeight(textarea) {
            $(textarea).css('height', 'auto'); // Reset the height
            var height = textarea.scrollHeight;
            $(textarea).css('height', height); // Adjust the value of 25 as needed
        }

        $(document).ready(function() {
            $('.image').click(function() {
                var src = $(this).attr('src');
                $('.image').removeClass('active');
                $(this).addClass('active');
                $('#image').attr('src', src);
            });

            var src = $('.image').attr('src');
            document.getElementsByClassName('image')[0].classList.add('active');
            $('#image').attr('src', src);

            $('#title_description').val($('#title_description').val().trim());

            // Call the function on page load
            adjustInputWidth($('#name'));
            adjustInputWidth($('#title_description'));
            // $('#title_description').css('width', $('#title_description').width() - 18);
            $('#title_description').css('min-height', 18);
            adjustInputWidth($('#date_created'));
            $('#date_created').attr('type', 'text');
        });

        $('#name').on('input', function() {
            var name = $('#name').val();
            if (name.length < 3 || name.length > 40) {
                $('#name').addClass('error');
                console.log('error')
            } else {
                $('#name').removeClass('error');
                console.log('success')
            }

            // Attach an input event listener to dynamically adjust the input width
            adjustInputWidth(this);
        });

        $('#title_description').on('input', function() {
            var title_description = $('#title_description').val();
            if (title_description.length < 3 || title_description.length > 40) {
                $('#title_description').addClass('error');
                console.log('error')
            } else {
                $('#title_description').removeClass('error');
                console.log('success')
            }

            // Attach an input event listener to dynamically adjust the input width
            adjustInputWidth(this);
            // if ($(this).val().length > 0) {
            //     $(this).css('width', $(this).width() - 18);
            // }
            adjustTextareaHeight(this);

        });

        function resetAll() {
            $('#name').attr('disabled', 'disabled');
            $('#title_description').attr('disabled', 'disabled');
            $('#date_created').attr('disabled', 'disabled');
            $('#date_created').attr('type', 'text');

            $('.icon-edit').removeClass('active');
            $('.icon-edit').removeClass('save-edit');

            $('.icon-edit').removeClass('fa-check');
            $('.icon-edit').addClass('fa-pencil');
        }

        $(document).on('click', '.icon-edit', function() {
            resetAll()
            $('.icon-edit').removeClass('active');
            $(this).removeClass('fa-pencil');
            $(this).addClass('fa-check');
            $(this).addClass('active');
            $(this).addClass('save-edit');
            // enable input
            if ($(this).data('id') == 'name') {
                $('#name').removeAttr('disabled');
            } else if ($(this).data('id') == 'title_description') {
                $('#title_description').removeAttr('disabled');
            } else if ($(this).data('id') == 'date_created') {
                $('#date_created').removeAttr('disabled');
                $('#date_created').attr('type', 'date');

            }
        });

        $(document).on('click', '.save-edit', function() {
            $('.icon-edit').removeClass('active');
            $(this).addClass('fa-pencil');
            $(this).removeClass('fa-check');
            $(this).removeClass('save-edit');
            // disable input
            if ($(this).data('id') == 'name') {
                $('#name').attr('disabled', 'disabled');
            } else if ($(this).data('id') == 'title_description') {
                $('#title_description').attr('disabled', 'disabled');
            } else if ($(this).data('id') == 'date_created') {
                $('#date_created').attr('disabled', 'disabled');
                $('#date_created').attr('type', 'text');
            }
        });

        $('#detail_description_editor').on('input', function() {
            $("#detail_description").val($("#detail_description_editor").html());
            console.log($("#detail_description").val());
        });

        $('#btn-save-edit').on('click', function() {
            $('#name').removeAttr('disabled');
            $('#title_description').removeAttr('disabled');
            $('#date_created').removeAttr('disabled');
            $('#form-update-release').submit();
        });
    </script>
@endsection


@section('php')
    @php
        function convertDate($date)
        {
            $date = date_create($date);
            return date_format($date, 'd/m/Y');
        }

        function name($name)
        {
            if (old('name')) {
                return old('name');
            }
            return $name;
        }

        function title_description($title_description)
        {
            if (old('title_description')) {
                return old('title_description');
            }
            return trim($title_description);
        }

        function detail_description($detail_description)
        {
            if (old('detail_description')) {
                return old('detail_description');
            }
            return trim($detail_description);
        }

        function date_created($date_created)
        {
            if (old('date_created')) {
                return old('date_created');
            }
            return $date_created;
        }

        function is_publish($is_publish)
        {
            if (old('is_publish') == true || $is_publish == 1) {
                return 'checked';
            }
            return null;
        }
    @endphp
@endsection

@section('content')
    <div class="content">
        <div class="image-container">
            <div class="image-title">
                <h1>Images</h1>
                {{ $errors }}

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
            <form id="form-update-release" action="{{ route('web_release_update', $release->id) }}" method="post"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="content-name">
                    <input type="text" name="name" id="name" value="{{ $release->name }}" disabled>
                    <i class="fa fa-pencil icon-edit" data-id="name"></i>
                </div>
                <div class="content-title-description">
                    <div class="title">
                        <span>
                            <strong>Title: </strong>
                            <textarea type="text" name="title_description" id="title_description" rows="1" disabled>
                                 {{ title_description($release->title_description) }}
                            </textarea>
                            <i class="fa fa-pencil icon-edit" data-id="title_description"></i>
                        </span>
                        <div class="content-publish">
                            <input type="checkbox" name="is_publish" id="is_publish" {{ is_publish($release->is_publish) }}>
                            <label for="is_publish">Publish</label>
                        </div>
                    </div>
                    <p><strong>Description: </strong> </p>
                    <div id="editor">
                    </div>
                    <textarea name="detail_description" id="detail_description" hidden>
                    </textarea>
                </div>
                <div class="content-date">
                    <p> <strong>Date Created: </strong>
                        <input type="date" name="date_created" id="date_created" value="{{ $release->date_created }}"
                            disabled>
                        <i class="fa fa-pencil icon-edit" data-id="date_created"></i>
                    </p>
                </div>
                <input type="button" id="btn-save-edit" value="Save">
            </form>
        </div>
    </div>
@endsection
