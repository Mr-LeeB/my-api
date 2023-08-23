@extends('release::layout.app_admin_nova')

@section('title', 'Create Release')

@section('css')
    <style>
        @include('release::admin.css.admin-create-release-css');
    </style>
@endsection

@section('javascript')
    @php
        $name = null;
        $title_description = null;
        $detail_description = null;
        $date_created = date('Y-m-d');
        $is_publish = null;
        $id = 0;
        $list_images = null;

        if ($release != null) {
            $name = old('name', $release->name);
            $title_description = old('title_description', $release->title_description);
            $detail_description = old('detail_description', $release->detail_description);
            $date_created = old('date_created', substr($release->created_at, 0, 10));
            if (old('is_publish', $release->is_publish) == true) {
                $is_publish = 'checked';
            } else {
                $is_publish = '';
            }
            $id = $release->id;
            $list_images = $release->images;
        }
    @endphp
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        header: [1, 2, 3, 4, 5, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    [{
                        list: 'ordered'
                    }, {
                        list: 'bullet'
                    }],
                    [{
                        'align': []
                    }],
                    ['clean'],
                    ['link'],
                ]
            },
        });
        let detail_description = '{!! $detail_description !!}';
        detail_description = quill.clipboard.convert(detail_description)
        quill.setContents(detail_description, 'silent');

        $(".ql-editor").attr('id', 'detail_description_editor');
    </script>
    <script>
        $('#btn-confirm-save').on('click', function() {
            // put data from quill editor into input
            $("#detail_description").val($(".ql-editor").html());

            var name = $('#name').val().trim();
            var title_description = $('#title_description').val().trim();
            var detail_description = $('#detail_description').val().trim();
            var date_created = $('#date_created').val();
            var img = $('#file_upload').files;
            var is_publish = $('#is_publish').is(':checked');

            if (detail_description == '<p><br></p>') {
                alert('Description must be not empty!');
                return;
            }

            if (name.length < 3 || name.length > 40) {
                alert('Name must be between 3 and 40 characters!');
                return;
            }

            if (name == '{{ $name }}') {
                $("#name").removeAttr('name');
            }

            if (title_description.length < 3 || title_description.length > 255) {
                alert('Title must be between 3 and 40 characters!');
                return;
            }

            // if (detail_description.length < 3 || detail_description.length > 4096) {
            //     alert('Description must be between 3 and 4096 characters!');
            //     return;
            // }

            if (date_created == '') {
                alert('Date Created must be not empty!');
                return;
            }

            if (img == null) {
                $('#file_upload').removeAttr('name');
            }
            if (is_publish) {
                $('#is_publish').val(1);
            } else {
                $('#is_publish').val(0);
            }

            // console.log($('.is-publish-checkbox').html());

            if ('{{ $release }}' != '') {
                $('#form-create-release').attr('action', '{{ route('web_release_update', $id) }}')
                $('#form-create-release').append('<input type="hidden" name="_method" value="PUT">');

                if (confirm('Are you sure you want to update this release?')) {
                    $('#form-create-release').submit();
                }
            } else {
                $('#form-create-release').submit();
            }
        });

        $(document).ready(function() {
            $(".btn-add-image").click(function() {
                $('#file_upload').trigger('click');
            });

            $('.list-input-hidden-upload').on('change', '#file_upload', function(event) {
                $(this).attr('id', 'files')
                let files = $('#files').prop('files');

                let input_type_file =
                    '<input type="file" name="images[]" id="file_upload" class="hidden" multiple>';
                $('.list-input-hidden-upload').append(input_type_file);

                for (let i = 0; i < event.target.files.length; i++) {
                    let today = new Date();
                    let time = today.getTime();
                    let random = Math.floor(Math.random() * 1000);
                    let image = event.target.files[i];
                    let file_name = event.target.files[i].name;
                    let box_image = $('<div class="box-image"></div>');
                    box_image.append('<img src="' + URL.createObjectURL(image) + '" class="picture-box">');
                    box_image.append('<div class="wrap-btn-delete"><span data-id=' + time + "_" + random +
                        ' class="btn-delete-image">x</span></div>');
                    $(".list-images").append(box_image);

                    const fileInput = document.querySelector('#file_upload');

                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(files[i]);

                    fileInput.files = dataTransfer.files;

                    $('#file_upload').attr('id', time + "_" + random);
                    $('.list-input-hidden-upload').append(input_type_file);
                }
                $('#files').remove();
            });

            $(".list-images").on('click', '.btn-delete-image', function() {
                let id = $(this).data('id');
                $('#' + id).remove();
                $(this).parents('.box-image').remove();
            });
        });

        $('#detail_description_editor').on('input', function() {
            $("#detail_description").val($("#detail_description_editor").html());
            console.log($("#detail_description").val());
        });
    </script>
@endsection

@section('content')
    <div class="content">
        <div class="create-content">
            <div class="create-release">
                @if ($release != null)
                    <h1>Edit release</h1>
                @else
                    <h1>Create new release</h1>
                @endif
                <form id="form-create-release" class="form-create" action="{{ route('web_release_store') }}" method="POST"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="text" id="name" name="name" placeholder="Name" value="{{ $name }}">
                    @if ($errors->has('name'))
                        <span style="color:red">{{ $errors->first('name') }} </span>
                    @endif

                    <input type="text" id="title_description" name="title_description" placeholder="Title"
                        value="{{ $title_description }}">
                    @if ($errors->has('title_description'))
                        <span style="color:red">{{ $errors->first('title_description') }} </span>
                    @endif

                    <textarea type="text" id="detail_description" name="detail_description" placeholder="Description" hidden>
                    </textarea>
                    <input type="date" id="date_created" name="date_created" placeholder="Date Created"
                        value="{{ $date_created }}">
                    @if ($errors->has('date_created'))
                        <span style="color:red">{{ $errors->first('date_created') }} </span>
                    @endif

                    <div class="is-publish-checkbox">
                        <input type="checkbox" name="is_publish" id="is_publish" {{ $is_publish }}>
                        <label for="is_publish"> Is Publish </label>
                    </div>
                    <div>
                        <div class="list-input-hidden-upload">
                            <input type="file" id="file_upload" class="hidden" multiple>
                        </div>
                        <button class="btn-add-image" type="button">
                            <i class="fa fa-plus" style="margin-right: 4px"> </i> Add images</button>
                        {{-- @if ($errors->has('images.*'))
                            <span style="color:red">{{ $errors->first('images') }} </span>
                        @endif --}}
                    </div>
                    <div class="list-images">
                        @if (isset($list_images) && !empty($list_images))
                            @foreach ($list_images as $key => $img)
                                <div class="box-image">
                                    <input type="hidden" name="images_old[]" value="{{ $img }}"
                                        id="img-{{ $key }}">
                                    <img src="{{ asset($img) }}" class="picture-box">
                                    <div class="wrap-btn-delete"><span data-id="img-{{ $key }}"
                                            class="btn-delete-image">x</span></div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    @if ($release != null)
                        <input type="hidden" name="id" id="id" value="{{ $id }}" />
                        <input type="button" id="btn-confirm-save" value="Update release">
                    @else
                        <input type="button" id="btn-confirm-save" value="Create new release">
                    @endif
                </form>
            </div>
            <div class="info-release-created-recently">
                <h3>Enter Description:</h3>
                @if ($errors->has('detail_description'))
                    <span style="color:red">{{ $errors->first('detail_description') }} </span>
                @endif
                <div id="editor">
                </div>
                @if (session('success'))
                    <h3 style="color:blue">Success!!</h3>
                    {{-- show release created recently --}}
                    {!! session('success') !!}
                @else
                    @if ($release == null)
                        <h4>Don't have Release(s) created recently!</h4>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection
