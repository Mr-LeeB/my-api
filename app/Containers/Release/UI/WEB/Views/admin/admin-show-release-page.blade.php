@extends('release::layout.app_admin_nova')

@section('title')
    {{ __('Release') }}
@endsection

@php
    $view_load_theme = 'base';
@endphp

@section('header_sub')
    <div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
        <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <h2>{{ __('Show Releases') }}</h2>
            </div>
        </div>
    </div>
@endsection

@once
    @push('after_header')
        <link href="{{ asset('theme/' . $view_load_theme . '/css/admin_show_release_css.css') }}" rel="stylesheet" type="text/css">
    @endpush
@endonce

<style>
    .undisplay {
        display: none;
    }

    .boloc:hover {
        cursor: pointer;
        background-color: aliceblue !important;
    }
</style>

@section('header_sub')
    <div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
        <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <h2>{{ __('Danh sách Release') }}</h2>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
        integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <script>
        $(document).ready(function() {
            $('#search-by-name').keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

            const url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);
            const limit = params.get('limit');
            let orderBy = params.get('orderBy');
            let sortedBy = params.get('sortedBy');

            if (orderBy != null && sortedBy != null) {
                $('.icon-' + orderBy).css('display', 'inline-block');
                $('.icon-' + orderBy).css('color', '#a9cef3');
                $('.icon-' + orderBy + '.icon-' + sortedBy).css('color', '#3699FF');
                $('.field-' + orderBy).css('color', '#3699FF');
            }

            if (limit != null) {
                $('.form-limit').val(limit);
            }
        });

        const url = new URL(window.location.href);
        const params = new URLSearchParams(url.search);

        let orderBy = params.get('orderBy');
        let sortedBy = params.get('sortedBy');
        let limit = params.get('limit');
        let page = params.get('page');
        let search = params.get('search');
        let searchFields = params.get('searchFields');

        $('.form-limit').on('change', function() {
            var changeLimit = $(this).val();

            var form = $("<form action='{{ route('web_release_get_all_release') }}' method='GET'></form>");

            form.append("<input type='hidden' name='limit' value='" + changeLimit + "'>");

            if (orderBy != null && sortedBy != null) {
                form.append("<input type='hidden' name='orderBy' value='" + orderBy + "'>");
                form.append("<input type='hidden' name='sortedBy' value='" + sortedBy + "'>");
            }

            if (search != null) {
                form.append("<input type='hidden' name='search' value='" + search + "'>");
            }

            if (searchFields != null) {
                form.append("<input type='hidden' name='searchFields' value='" + searchFields + "'>");
            }

            $(document.body).append(form);
            form.submit();
        });

        $('.btn-search-release').on('click', function() {
            var url = "http://" + window.location.host + '/releases?search=';
        });

        function activeBody(id) {
            $('#body' + id).toggleClass('unactive');
        }

        $('.input-group-text').on('click', function() {
            $('.show-searchable').toggleClass('unactive');
        });

        $('.set-searchable').on('click', function() {
            $('.searchable').html($(this).html());
        });

        function searchRelease() {
            var search = $('#search-by-name').val();
            var url = '';
            if ($('#field-name').is(':checked')) {
                url = "{{ route('web_release_search') }}";
                $('#search-by-name').attr('type', 'text');
                $('#search-by-name').attr('name', 'name');
                $('#search-by-name').attr('placeholder', 'Search by Name');

            } else if ($('#field-id').is(':checked')) {
                url = "{{ route('web_release_search_by_id') }}";
                $('#search-by-name').attr('name', 'id');
                $('#search-by-name').attr('type', 'number');
                $('#search-by-name').attr('placeholder', 'Search by Id');

            } else if ($('#field-date').is(':checked')) {
                url = "{{ route('web_release_search_by_date') }}";
                $('#search-by-name').attr('name', 'date_created');
                $('#search-by-name').attr('type', 'date');
            }

            if (search.trim() == '') {
                $('#result').html('');
                return;
            }

            $.ajax({
                url: url,
                type: "POST",
                data: $('#form-search-release').serialize(),
                success: function(data) {
                    $('#result').html(
                        `<p>Result: ${data.length} release(s)</p>
                        <div class="release-note-list">
                          ${data.map((release) => {
                              release.detail_description = release.detail_description.length > 62 ? release.detail_description.substring(0, 62).concat('...'):release.detail_description;
                              return`<div class="release-note-item">
                                   <div class="release-note-item-header" onclick="activeBody(${release.id})">
                                     <div class="release-note-item-header-title">
                                       ${release.name}
                                     </div>
                                     <div class="release-note-item-header-date">
                                       ${release.created_at.substring(0, 10)}
                                     </div>
                                   </div>
                                   <div class="release-note-item-body unactive" id="body${release.id}">
                                     <div class="release-note-item-body-title ">
                                       Title: ${release.title_description}
                                     </div>
                                     <div class="release-note-item-body-description">
                                       Description: ${release.detail_description}
                                     </div>
                                     <div class="more-detail">
                                       <a href="/releases/${release.id}">More detail</a>
                                     </div>
                                   </div>
                                 </div>`}).join('')}
                        </div>`
                    );
                },
                error: function(data) {
                    $('#result').html(
                        '<p>Result: 0 release(s)</p>'
                    )
                }
            });
        }

        function confirmDeleteMoreRelease(releaseIDs) {
            for (var i = 0; i < releaseIDs.length; i++) {
                if (!document.getElementById('select_release' + releaseIDs[i]).checked) {
                    document.getElementById('selectedManyReleaseToDel' + releaseIDs[i].toString()).removeAttribute("name");
                }
            }
            if (confirm("Are you sure you want to delete this release?")) {
                document.querySelector('#form-delete-more-release').submit();
            }
        }

        function checkOne(releaseID_json) {
            var checkAll = document.getElementById('checkAll');
            var count = 0;
            for (var i = 0; i < releaseID_json.length; i++) {
                if (document.getElementById('select_release' + releaseID_json[i]).checked == true) {
                    count++;
                }
            }
            if (count == releaseID_json.length) {
                checkAll.checked = true;
            } else {
                checkAll.checked = false;
            }

            if (count > 0) {
                document.getElementsByClassName('delete-more-release')[0].style.display = "block";
            } else {
                document.getElementsByClassName('delete-more-release')[0].style.display = "none";
            }
        }

        function checkAll(releaseID_json) {
            var checkAll = document.getElementById('checkAll');
            var select_release = document.getElementById('select_release');
            if (checkAll.checked == true) {
                for (var i = 0; i < releaseID_json.length; i++) {
                    document.getElementById('select_release' + releaseID_json[i]).checked = true;
                    document.getElementsByClassName('delete-more-release')[0].style.display = "block";

                }
            } else {
                for (var i = 0; i < releaseID_json.length; i++) {
                    document.getElementById('select_release' + releaseID_json[i]).checked = false;
                    document.getElementsByClassName('delete-more-release')[0].style.display = "none";
                }
            }
        }

        function deleteRelease(id) {
            if (confirm("Are you sure you want to delete this release?")) {
                $('#form-delete-release-id-' + id).submit();
            }
        }

        function sortRelease(newOrderBy) {
            var form = $("<form action='{{ route('web_release_get_all_release') }}' method='GET'></form>");

            //if orderBy is null or not equal newOrderBy => set sortedBy = asc
            if (orderBy == null || orderBy != newOrderBy) {
                orderBy = newOrderBy;
                sortedBy = 'asc';
            } else {
                //if orderBy is equal newOrderBy => change sortedBy
                if (sortedBy == null) {
                    sortedBy = 'asc';
                } else {
                    if (sortedBy == 'asc') {
                        sortedBy = 'desc';
                    } else {
                        sortedBy = 'asc';
                    }
                }
            }

            if (limit != null) {
                form.append("<input type='hidden' name='limit' value='" + limit + "'>");
            }

            form.append("<input type='hidden' name='orderBy' value='" + orderBy + "'>");
            form.append("<input type='hidden' name='sortedBy' value='" + sortedBy + "'>");

            if (page != null) {
                form.append("<input type='hidden' name='page' value='" + page + "'>");
            }

            if (search != null) {
                form.append("<input type='hidden' name='search' value='" + search + "'>");
            }

            if (searchFields != null) {
                form.append("<input type='hidden' name='searchFields' value='" + searchFields + "'>");
            }

            $(document.body).append(form);
            form.submit();
        }

        function showReleaseDetailPage(id) {
            window.location.href = '/releases/' + id;
        }

        function enableEdit(id) {
            window.location.href = '/releases/' + id + '/edit';
        }

        $('#search_release').on('click', function() {
            var title = $('.search-title').val();
            var description = $('.search-description').val();
            var date = $('.search-date').val();

            var field_title = $('.field-search-title').val();
            var field_description = $('.field-search-description').val();

            var url = "{{ route('web_release_get_all_release') }}";

            if (title != '') {
                url += '?search=title_description:' + title;
            }

            if (description != '') {
                if (title != '') {
                    url += '&detail_description:' + description;
                } else {
                    url += '?search=detail_description:' + description;
                }
            }

            if (date != '') {
                if (title != '' || description != '') {
                    url += '&created_at:' + date;
                } else {
                    url += '?search=created_at:' + date;
                }
            }

            if (field_title != 'like') {
                if (title != '') {
                    url += '&searchFields=title_description:' + field_title;
                } else {
                    url += '?searchFields=title_description:' + field_title;
                }
            }

            if (field_description != 'like') {
                if (title != '' || description != '') {
                    url += '&searchFields=detail_description:' + field_description;
                } else {
                    url += '?searchFields=detail_description:' + field_description;
                }
            }

            window.location.href = url;
        });
    </script>
@endsection

@php
    $releaseID = [];
    foreach ($releases as $key => $value) {
        array_push($releaseID, $value->id);
    }
    $releaseID_json = json_encode($releaseID);
@endphp

@section('content')
    <div class="col-12">

        {{-- @can('search-users')
            <div class="create-seach-area">
                <div class="search-area">
                    <h2>Search releases</h2>
                    <div class="search">
                        <form class="form-search" id="form-search-release" action="" method="POST">
                            {{ csrf_field() }}
                            <input type="text" name="name" id="search-by-name" placeholder="Search by Name"
                                oninput="searchRelease()" autocomplete="off">
                        </form>
                        <span>Search by: </span>
                        <div class="select-field-search">
                            <input type="radio" onclick="searchRelease()" name="field" id="field-name" checked>
                            <label for="field-name"> Name </label>

                            <input type="radio" onclick="searchRelease()" name="field" id="field-id">
                            <label for="field-id"> ID </label>

                            <input type="radio" onclick="searchRelease()" name="field" id="field-date">
                            <label for="field-date"> Date </label>
                        </div>
                    </div>

                    <div class="result" id="result">
                    </div>
                </div>
                <div class="create-release">
                    <div class="create">
                        <a href="{{ route('web_release_create') }}"> <button class="btn btn-primary mt-6">Create New
                                Release</button></a>
                    </div>
                </div>
            </div>
        @endcan --}}
        <div class="row">
            @can('search-users')
                <div class="col">
                    <div class="card card-custom gutter-b card-stretch">
                        {{-- thêm class boloc --}}
                        <div class="card-header boloc border-0 py-5">
                            <h3 class="card-title"><span class="font-weight-bolder">{{ __('Bộ Lọc') }}</span></h3>
                            <div class="card-toolbar">
                                <!-- // -->
                            </div>
                        </div>

                        <div class="card-body boloc-show unactive">
                            <div class="tab-content">
                                <form class="form gutter-b col" action="">
                                    <div class="form-group row mt-4">
                                        <label class="col-3 col-form-label">Title: </label>
                                        <div class="col-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control search-title"
                                                    placeholder="Enter title" />
                                                <div class="input-group-append">
                                                    <select
                                                        class="field-search-title form-control form-control-nm font-weight-bold border-0 bg-light"
                                                        style="width: 75px;">
                                                        <option value="like">like</option>
                                                        <option value="=">=</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Description: </label>
                                        <div class="col-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control search-description"
                                                    placeholder="Enter description" />
                                                <div class="input-group-append">
                                                    <select
                                                        class="field-search-description form-control form-control-nm font-weight-bold border-0 bg-light"
                                                        style="width: 75px;">
                                                        <option value="like">like</option>
                                                        <option value="=">=</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-3 col-form-label">Date Created: </label>
                                        <div class="col-9">
                                            <div class="input-group date">
                                                <input type="date" class="form-control search-date" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row-reverse">
                                        <button type="button" id="search_release" class="btn btn-primary btn-block"
                                            style="width: 180px">{{ __('Lọc danh sách') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
        @can('create-admins')
            <div class="create-release">
                <div class="create">
                    <a href="{{ route('web_release_create') }}">
                        <button class="btn btn-primary mt-6">
                            Create New Release
                        </button>
                    </a>
                </div>
            </div>
        @endcan

        {{-- <div class="multi-search">
            <form class="form">
                <div class="card-header">
                    <h2>Search releases</h2>
                </div>
                <div class="card-body" style="background: #fff">
                    <div class="form-group row mt-4">
                        <label class="col-3 col-form-label">Title: </label>
                        <div class="col-9">
                            <input type="text" class="form-control search-title" placeholder="Enter title" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Description: </label>
                        <div class="col-9">
                            <div class="input-group">
                                <input type="text" class="form-control search-description"
                                    placeholder="Enter description" />
                                <div class="input-group-append">
                                    <select class="form-control form-control-sm font-weight-bold mr-4 border-0 bg-light"
                                        style="width: 75px;">
                                        <option value="like">like</option>
                                        <option value="=">=</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">Date Created: </label>
                        <div class="col-9">
                            <div class="input-group date">
                                <input type="date" class="form-control search-date" />

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer mb-6">
                    <button type="button" class="btn btn-primary pl-8 pr-8 btn-search-release">Search</button>
                </div>
            </form>
        </div> --}}

        <div class="table-list-all-release">
            @if (session('success'))
                {!! session('success') !!}
            @endif
            <div class="d-flex align-items-center py-3">
                {{-- <div class="d-flex align-items-center">
                <div class="mr-2 text-muted">Loading...</div>
                <div class="spinner mr-10"></div>
            </div> --}}

                <select class="form-limit form-control form-control-sm font-weight-bold mr-4 border-0 bg-light"
                    style="width: 75px;">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-muted">Displaying {{ $releases->count() }} of {{ $all_Releases_count }} records</span>
            </div>

            @can('delete-users')
                <div class="delete-more-release unactive">
                    <form action="{{ route('web_release_delete_bulk') }}" method="POST" id="form-delete-more-release">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        @foreach ($releaseID as $id)
                            <input type="hidden" name="id[]" id="selectedManyReleaseToDel{{ $id }}"
                                value="{{ $id }}">
                        @endforeach
                        <input type="button" onclick="confirmDeleteMoreRelease({{ $releaseID_json }})"
                            class="btn btn-light-danger font-weight-bold mr-2" value="Delete Releases">
                    </form>
                </div>
            @endcan

            <div class="card card-custom card-fit">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Danh sách') }} Release</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                @can('delete-users')
                                    <td>
                                        <input type="checkbox" id="checkAll" onclick="checkAll({{ $releaseID_json }})">
                                    </td>
                                @endcan
                                <td onclick="sortRelease('id')" class="field-id">ID
                                    <i class="la la-long-arrow-up icon-nm icon icon-asc icon-id"></i>
                                    <i class="la la-long-arrow-down icon-nm icon icon-desc icon-id"></i>
                                </td>
                                <td onclick="sortRelease('name')" class="field-name">Name
                                    <i class="la la-long-arrow-up icon-nm icon icon-asc icon-name"></i>
                                    <i class="la la-long-arrow-down icon-nm icon icon-desc icon-name"></i>
                                </td>
                                <td class="text-center field-title_description"
                                    onclick="sortRelease('title_description')">
                                    Title
                                    <i class="la la-long-arrow-up icon-nm icon icon-asc icon-title_description"></i>
                                    <i class="la la-long-arrow-down icon-nm icon icon-desc icon-title_description"></i>
                                </td>
                                <td class="text-center field-detail_description"
                                    onclick="sortRelease('detail_description')">Description
                                    <i class="la la-long-arrow-up icon-nm icon icon-asc icon-detail_description"></i>
                                    <i class="la la-long-arrow-down icon-nm icon icon-desc icon-detail_description"></i>
                                </td>
                                <td class="text-center field-created_at" onclick="sortRelease('created_at')">Date Created
                                    <i class="la la-long-arrow-up icon-nm icon icon-asc icon-created_at"></i>
                                    <i class="la la-long-arrow-down icon-nm icon icon-desc icon-created_at"></i>
                                </td>
                                <td>Is Publish</td>
                                <td class="text-center">Images</td>
                                @canany(['search-users', 'update-users', 'delete-users'])
                                    <td class="text-center" colspan="3">Actions</td>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            @if ($releases->isNotEmpty())
                                @can('list-users')
                                    @foreach ($releases as $release)
                                        <tr class="bg-hover-secondary">
                                            @can('delete-users')
                                                <td style="text-align: center;">
                                                    <input type="checkbox" id="select_release{{ $release->id }}"
                                                        onclick="checkOne({{ $releaseID_json }})">
                                                </td>
                                            @endcan
                                            <td>
                                                {{ $release->id }}
                                            </td>
                                            <td>
                                                {{ $release->name }}
                                            </td>
                                            <td class="text-center">
                                                {{ $release->title_description }}
                                            </td>
                                            <td class="text-center">
                                                @if (strlen($release->detail_description) > 40)
                                                    {!! mb_str_split($release->detail_description, 40)[0] . '...' !!}
                                                @else
                                                    {!! $release->detail_description !!}
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ substr($release->created_at, 0, 10) }}
                                            </td>
                                            <td>
                                                {{ $release->is_publish }}
                                            </td>
                                            <td>
                                                <div class="small-image d-flex flex-column align-items-center">
                                                    @if (isset($release->images) && count($release->images) > 0 && $release->images[0] != '')
                                                        {{-- <img src="{{ asset($release->images[0]) }}" alt="Image"
                                                        style="width: 50px; height: 50px; border-radius: 10px"> --}}
                                                        <div class="symbol symbol-40 mr-3">
                                                            <img alt="Image" src="{{ asset($release->images[0]) }}" />
                                                        </div>
                                                        @if (count($release->images) > 1)
                                                            <span style="font-size: 12px"> More
                                                                {{ count($release->images) - 1 }}
                                                                image(s)</span>
                                                        @endif
                                                    @else
                                                        <p> No Image </p>
                                                    @endif
                                                </div>
                                            </td>
                                            @can('search-users')
                                                <td style="text-align: center">
                                                    <i class="fa la-info-circle btn-show-info" data-toggle="tooltip"
                                                        title="Detail Release"
                                                        onclick="showReleaseDetailPage({{ $release->id }})"></i>
                                                </td>
                                            @endcan
                                            @can('update-users')
                                                <td style="text-align: center">
                                                    <i class="fa fa-pen btn-edit" data-toggle="tooltip" title="Edit Release"
                                                        onclick="enableEdit({{ $release->id }})"></i>
                                                </td>
                                            @endcan
                                            @can('delete-users')
                                                <td style="text-align: center">
                                                    <form id="form-delete-release-id-{{ $release->id }}" method="POST"
                                                        action="{{ route('web_release_delete', $release->id) }}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                    </form>
                                                    <i class="fa fa-trash btn-delete-one" data-toggle="tooltip"
                                                        title="Delete Release" onclick="deleteRelease({{ $release->id }})"></i>
                                                </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                @endcan
                            @else
                                <tr>
                                    <td colspan="100%" class=" bg-hover-secondary text-center">
                                        <b>{{ __('global.no_data') }}</b>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="paginate">
                    @if (isset($releases) && count($releases) > 0)
                        {{ $releases->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- </div> --}}
@endsection


@once
    @push('after_script')
        <script>
            $('.boloc').on('click', function() {
                $('.boloc-show').toggleClass('unactive');
            });
        </script>
    @endpush
@endonce
