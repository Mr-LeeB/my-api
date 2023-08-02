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

        // $("#identifier").on("submit", function() {
        //     $("#hiddenArea").val($("#quillArea").html());
        // })
    </script>

    <script>
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
            this.size = this.value.length + 1;
            console.log(this.size)
        });

        function resetAll() {
            $('#name').attr('disabled', 'disabled');
            $('#title_description').attr('disabled', 'disabled');
            $('#date_created').attr('disabled', 'disabled');

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
            }
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
            return $title_description;
        }

        function detail_description($detail_description)
        {
            if (old('detail_description')) {
                return old('detail_description');
            }
            return $detail_description;
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
            <form action="" method="post">
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
                            <input type="text" name="title_description" id="title_description"
                                value="{{ $release->title_description }}" disabled=>
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
                </div>
                <div class="content-date">
                    <p> <strong>Date Created: </strong>
                        <input type="date" name="date_created" id="date_created" value="{{ $release->date_created }}"
                            disabled>
                        <i class="fa fa-pencil icon-edit" data-id="date_created"></i>
                    </p>
                </div>

            </form>
        </div>
    </div>
@endsection
