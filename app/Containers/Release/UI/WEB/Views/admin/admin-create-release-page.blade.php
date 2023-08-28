@extends('release::layout.app_admin_nova')

@section('title')
    {{ __('Create Release') }}
@endsection

@php
    $view_load_theme = 'base';
@endphp

@section('header_sub')
    <div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
        <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <h2>{{ __('Create New Release') }}</h2>
            </div>
        </div>
    </div>
@endsection

@once
    @push('after_header')
        <link href="{{ asset('theme/' . $view_load_theme . '/css/admin_create_release_css.css') }}" rel="stylesheet"
            type="text/css">
    @endpush
@endonce

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
        $("#name").on("input", function() {
            if ($("#name").val().length < 3) {
                $(".validate-name").html('Name must be at least 3 characters!');
                $(".validate-name").removeClass('unactive');
            } else {
                $(".validate-name").addClass('unactive');
            }

            if ($("#name").val().length > 40) {
                $(".validate-name").html('Name must be less than 40 characters!');
                $(".validate-name").removeClass('unactive');
            } else {
                $(".validate-name").addClass('unactive');
            }
        });

        $("#title_description").on("input", function() {
            if ($("#title_description").val().length < 3) {
                $(".validate-title").html('Title must be at least 3 characters!');
                $(".validate-title").removeClass('unactive');
            } else {
                $(".validate-title").addClass('unactive');
            }

            if ($("#title_description").val().length > 255) {
                $(".validate-title").html('Title must be less than 255 characters!');
                $(".validate-title").removeClass('unactive');
            } else {
                $(".validate-title").addClass('unactive');
            }
        });

        $('#detail_description_editor').on('input', function() {
            var detail_description = $("#detail_description").val($("#detail_description_editor").html()).val()
                .trim().replace(/<[^>]*>/g, '');
            if (detail_description.length < 3) {
                $(".validate-description").html('Description must be at least 3 characters!');
                $(".validate-description").removeClass('unactive');
            } else {
                $(".validate-description").addClass('unactive');
            }
        });

        $('#btn-confirm-save').on('click', function() {
            // put data from quill editor into input
            $("#detail_description").val($(".ql-editor").html());

            var name = $('#name').val().trim();
            var title_description = $('#title_description').val().trim();
            var detail_description = $('#detail_description').val().trim().replace(/<[^>]*>/g, '');
            var date_created = $('#date_created').val();
            var img = $('#file_upload').files;
            var is_publish = $('#is_publish').is(':checked');

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

            if (detail_description.length < 3) {
                alert("Description must be at least 3 characters!");
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
                    // let file_name = event.target.files[i].name;
                    let box_image = $('<div class="box-image"></div>');
                    // box_image.append('<img src="' + URL.createObjectURL(image) + '" class="picture-box">');
                    // box_image.append('<div class="wrap-btn-delete"><span data-id=' + time + "_" + random +
                    //     ' class="btn-delete-image">x</span></div>');
                    box_image.append(`
                                <div class="image-input image-input-outline" id="image_${time}_${random}">
                                <div class="image-input-wrapper" style="background-image: url(${URL.createObjectURL(image)})"></div>

                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                    data-action="change" data-toggle="tooltip" title=""
                                    data-original-title="Change">
                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                    <input type="file" id="_${time}_${random}" accept=".png, .jpg, .jpeg" />
                                </label>

                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" 
                                    data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
		                            <i class="ki ki-bold-close icon-xs text-muted"></i>
	                            </span>

                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                    data-action="remove" data-toggle="tooltip" title="Remove" >
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>
                            </div>`);


                    $(".list-images").append(box_image);

                    const fileInput = document.querySelector('#file_upload');

                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(files[i]);

                    fileInput.files = dataTransfer.files;

                    $('#file_upload').attr('id', time + "_" + random);

                    $('.list-input-hidden-upload').append(input_type_file);

                    id = time + "_" + random;
                    initActionImage(id, box_image);
                }
                $('#files').remove();
            });

            function initActionImage(id, box_image) {
                var img = new KTImageInput("image_" + id);
                img.on('change', function() {
                    const files = $('#_' + id).prop('files');
                    let fileInput = document.getElementById(id) ?? document.getElementById("new_" + id);

                    if (fileInput.files != null) {
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(files[0]);

                        fileInput.files = dataTransfer.files;
                    } else {
                        let input_type_file =
                            '<input type="file" name="images[]" id="new_' + id +
                            '" class="hidden" multiple>';
                        $('.list-input-hidden-upload').append(input_type_file);

                        fileInput = document.getElementById("new_" + id);

                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(files[0]);

                        $('#' + id).remove();

                        fileInput.files = dataTransfer.files;
                    }
                });

                img.on('cancel', function() {
                    $('#' + id).remove();
                });

                img.on('remove', function() {
                    $('#' + id).remove();
                    box_image.remove();
                });
            }

            @if (isset($release) && $release != null)
                @foreach ($list_images as $key => $img)
                    id = '{{ $key }}';
                    initActionImage(id, $('.box-image').eq({{ $key }}));
                @endforeach
            @endif
        });
    </script>
@endsection

@section('content')
    <div class="col-12">
        <div class="row">
            <div class="col-6">
                <div class="card-header">
                    <h3 class="card-title">
                        @if ($release != null)
                            {{ __('Edit release') }}
                        @else
                            {{ __('Create new release') }}
                        @endif
                    </h3>
                </div>
                <form id="form-create-release" class="form" action="{{ route('web_release_store') }}" method="POST"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card-body" style="background: white">
                        <div class="form-group">
                            <label>Release Name:</label>
                            <input type="text" class="form-control form-control-solid" id="name" name="name"
                                placeholder="Enter release name" value="{{ $name }}" />
                            <span class="form-text text-muted validate-name unactive">Please enter release name</span>
                            @if ($errors->has('name'))
                                <span style="color:red">{{ $errors->first('name') }} </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Release Title:</label>
                            <input type="text" class="form-control form-control-solid" id="title_description"
                                name="title_description" placeholder="Enter release title"
                                value="{{ $title_description }}" />
                            <span class="form-text text-muted validate-title unactive">Please enter title</span>
                            @if ($errors->has('title_description'))
                                <span style="color:red">{{ $errors->first('title_description') }} </span>
                            @endif
                        </div>
                        <textarea type="text" id="detail_description" name="detail_description" placeholder="Description" hidden>
                </textarea>
                        <div class="form-group">
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    <input type="checkbox" name="is_publish" id="is_publish" {{ $is_publish }} />
                                    <span></span>
                                    Is Publish
                                </label>
                            </div>
                        </div>
                        <div>
                            <div class="list-input-hidden-upload">
                                <input type="file" id="file_upload" class="hidden"
                                    accept=".jpeg, .png, .jpg, .gif, .svg, .webp" multiple>
                            </div>
                            <button class="btn btn-secondary btn-add-image" type="button">
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
                                            id="{{ $key }}">
                                        <div class="image-input image-input-outline" id="image_{{ $key }}">
                                            <div class="image-input-wrapper"
                                                style="background-image: url('{{ asset($img) }}')"></div>

                                            <label
                                                class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                data-action="change" data-toggle="tooltip" title=""
                                                data-original-title="Change">
                                                <i class="fa fa-pen icon-sm text-muted"></i>
                                                <input type="file" id="_{{ $key }}"
                                                    accept=".jpeg, .png, .jpg, .gif, .svg, .webp" />
                                            </label>

                                            <span
                                                class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                            </span>

                                            <span
                                                class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                data-action="remove" data-toggle="tooltip" title="Remove">
                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        @if ($release != null)
                            <input type="hidden" name="id" id="id" value="{{ $id }}" />
                            <input type="button" class="btn btn-primary mr-2" id="btn-confirm-save" value="Update">
                        @else
                            <input type="button" class="btn btn-primary mr-2" id="btn-confirm-save" value="Save">
                        @endif
                    </div>
                </form>
            </div>
            <div class="col-6">
                <div class="card card-custom">
                    <div class="card-header">
                        <h2 class="card-title">
                            Description
                        </h2>
                    </div>
                    <div class="card-body">
                        <div id="editor" style="height: 318px">
                        </div>
                        <span class="form-text text-muted validate-description unactive">Please enter description</span>
                        @if ($errors->has('detail_description'))
                            <span style="color:red">{{ $errors->first('detail_description') }} </span>
                        @endif
                    </div>
                    <div class="card-footer">
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
        </div>
    </div>
@endsection
