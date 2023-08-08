@extends('release::layout.app_admin_nova')

@section('title', 'Release')

@section('css')
    <style>
        @include('release::admin.css.admin-show-release-css');
    </style>
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
        });

        $(document).ready(function() {
            const url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);

            let orderBy = params.get('orderBy');
            let sortedBy = params.get('sortedBy');
            const limit = params.get('limit');
            if (orderBy != null && sortedBy != null) {
                $('#orderBy').attr('name', 'orderBy');
                $('#orderBy').val(orderBy);

                $('#sortedBy').attr('name', 'sortedBy');
                $('#sortedBy').val(sortedBy);
            }
            if (limit != null) {
                $('#limit').attr('name', 'limit');
                $('#limit').val(limit);
            }
            if (orderBy != null && sortedBy != null) {
                // in hoa chu cai dau
                order = orderBy.charAt(0).toUpperCase() + orderBy.slice(1);
                sorted = sortedBy.charAt(0).toUpperCase() + sortedBy.slice(1);
                $('#noti-orderBy').html(order);
                $('#noti-sortedBy').html(sorted);
                $('.noti-sorted').css('display', 'inline-block');
            }
            if (limit != null) {
                $('.limit').html(limit);
            }

            $('.all-releases').html('{{ $all_Releases_count }}');

        });

        $('.set-limit').on('click', function() {
            var limit = $(this).attr('data-limit');
            $('#limit').val(limit);
            $('#limit').attr('name', 'limit');
            $('#form-sort-release').submit();
        });

        $('.btn-search-release').on('click', function() {
            var url = "http://" + window.location.host + '/releases?search=';


            console.log(url);
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
                                                            ${release.date_created}
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

        function sortRelease(orderBy, sortedBy) {
            $('#orderBy').val(orderBy.trim());
            $('#sortedBy').val(sortedBy.trim());

            $('#orderBy').attr('name', 'orderBy');
            $('#sortedBy').attr('name', 'sortedBy');

            $('#form-sort-release').submit();
        }

        function showReleaseDetailPage(id) {
            window.location.href = '/releases/' + id;
        }

        function enableEdit(id) {
            window.location.href = '/releases/' + id + '/edit';
        }
    </script>
@endsection

@section('php')
    @php
        $releaseID = [];
        foreach ($releases as $key => $value) {
            array_push($releaseID, $value->id);
        }
        $releaseID_json = json_encode($releaseID);

        function detail_description($description)
        {
            if (strlen($description) > 50) {
                // return substr($description, 0, 37) . '...';
                return mb_str_split($description, 60)[0] . '...';
            }
            return $description;
        }

        function tooltip_description($id, $description)
        {
            $seeMore = '<a style="color:blue"  href="/releases/' . $id . '" >See more</a>';
            if (strlen($description) > 100) {
                return substr($description, 0, 100) . '...' . $seeMore;
            }
            return $description . '</br>' . $seeMore;
        }
    @endphp
@endsection


@section('content')
    {{-- <div class="content"> --}}
    <div class="title">
        <h1> Release Manage</h1>
    </div>
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

    <div class="multi-search">
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
                            <input type="text" class="form-control search-description" placeholder="Enter description" />
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <span class="searchable">like</span>
                                    <div class="show-searchable unactive">
                                        <div class="set-searchable">like</div>
                                        <div class="set-searchable">=</div>
                                    </div>
                                </span>
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
    </div>
    <div class="delete-more-release">
        <form action="{{ route('web_release_delete_bulk') }}" method="POST" id="form-delete-more-release">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            @foreach ($releaseID as $id)
                <input type="hidden" name="id[]" id="selectedManyReleaseToDel{{ $id }}"
                    value="{{ $id }}">
            @endforeach
            <input type="button" onclick="confirmDeleteMoreRelease({{ $releaseID_json }})" class="btn-delete"
                value="Delete Releases">
        </form>
    </div>
    <div class="table-list-all-release">
        @if (session('success'))
            {!! session('success') !!}
        @endif
        <div class="sort">
            <form id="form-sort-release" action="{{ route('web_release_get_all_release') }}" method="GET">
                <input type="hidden" id="orderBy">
                <input type="hidden" id="sortedBy">
                <input type="hidden" id="limit">
            </form>
        </div>
        <div class="sort-and-limit">
            <div class="dropdown">
                <span>Show <span class="limit">10</span> in <span class="all-releases">0</span> release(s)</span>
                <div class="dropdown-content">
                    <a class="set-limit" data-limit='10'><span>Show 10 in <span class="all-releases">0</span>
                            release(s)</span></a>
                    <a class="set-limit" data-limit='20'><span>Show 20 in <span class="all-releases">0</span>
                            release(s)</span></a>
                    <a class="set-limit" data-limit='50'><span>Show 50 in <span class="all-releases">0</span>
                            release(s)</span></a>
                    <a class="set-limit" data-limit='100'><span>Show 100 in <span class="all-releases">0</span>
                            release(s)</span></a>
                </div>
            </div>
            <p class="noti-sorted"> Sorted <span id="noti-sortedBy"></span> follow <span id="noti-orderBy"></span> </p>
        </div>
        <table>
            <thead>
                <th><input type="checkbox" id="checkAll" onclick="checkAll({{ $releaseID_json }})"></th>
                <th>
                    <div class="th-sort">
                        <span>ID</span>
                        <div class="sort-item">
                            <i class="fa fa-sort-up icon-sort-item asc" aria-hidden="true"
                                onclick="sortRelease('id','asc')"></i>
                            <i class="fa fa-sort-down icon-sort-item" aria-hidden="true"
                                onclick="sortRelease('id','desc')"></i>
                        </div>
                    </div>
                </th>
                <th>
                    <div class="th-sort">
                        <span>Name</span>
                        <div class="sort-item">
                            <i class="fa fa-sort-up icon-sort-item asc" aria-hidden="true"
                                onclick="sortRelease('name','asc')"></i>
                            <i class="fa fa-sort-down icon-sort-item" aria-hidden="true"
                                onclick="sortRelease('name','desc')"></i>
                        </div>
                    </div>
                </th>
                <th>
                    <div class="th-sort">
                        <span>Title</span>
                        <div class="sort-item">
                            <i class="fa fa-sort-up icon-sort-item asc" aria-hidden="true"
                                onclick="sortRelease('title_description','asc')"></i>
                            <i class="fa fa-sort-down icon-sort-item" aria-hidden="true"
                                onclick="sortRelease('title_description','desc')"></i>
                        </div>
                    </div>
                </th>
                <th>
                    <div class="th-sort">
                        <span>Description</span>
                        <div class="sort-item">
                            <i class="fa fa-sort-up icon-sort-item asc" aria-hidden="true"
                                onclick="sortRelease('detail_description','asc')"></i>
                            <i class="fa fa-sort-down icon-sort-item" aria-hidden="true"
                                onclick="sortRelease('detail_description','desc')"></i>
                        </div>
                    </div>
                </th>
                <th>
                    <div class="th-sort">
                        <span>Date Created</span>
                        <div class="sort-item">
                            <i class="fa fa-sort-up icon-sort-item asc" aria-hidden="true"
                                onclick="sortRelease('date_created','asc')"></i>
                            <i class="fa fa-sort-down icon-sort-item" aria-hidden="true"
                                onclick="sortRelease('date_created','desc')"></i>
                        </div>
                    </div>
                </th>
                <th>Is Publish</th>
                <th>Images</th>
                <th colspan="3">Actions</th>
            </thead>
            <tbody>
                @foreach ($releases as $release)
                    <tr>
                        <td style="text-align: center;">
                            <input type="checkbox" id="select_release{{ $release->id }}"
                                onclick="checkOne({{ $releaseID_json }})">
                        </td>
                        <td style="text-align: center;">{{ $release->id }}</td>
                        <td>{{ $release->name }}</td>
                        <td>{{ $release->title_description }}</td>
                        <td>
                            {!! detail_description($release->detail_description) !!}
                        </td>

                        <td style="text-align: center;">{{ $release->date_created }}</td>
                        <td style="text-align: center;">{{ $release->is_publish }}</td>
                        <td
                            style="display: flex;
                                      text-align: center;
                                      flex-direction: column;
                                      justify-content: center;
                                      align-items: center;">
                            @if (isset($release->images) && count($release->images) > 0 && $release->images[0] != '')
                                <img src="{{ asset($release->images[0]) }}" alt="Image"
                                    style="width: 50px; height: 50px; border-radius: 10px">
                                @if (count($release->images) > 1)
                                    <span style="font-size: 12px"> More {{ count($release->images) - 1 }}
                                        image(s)</span>
                                @endif
                            @else
                                <p> No Image </p>
                            @endif
                        <td style="text-align: center;">
                            <input class="btn-edit" type="button" id="edit-release-{{ $release->id }}"
                                onclick="showReleaseDetailPage({{ $release->id }})" value="More Detail">
                        </td>
                        <td>
                            <i class="fa fa-pen btn-edit" onclick="enableEdit({{ $release->id }})"></i>
                        </td>
                        <td style="text-align: center;">
                            <form id="form-delete-release-id-{{ $release->id }}" method="POST"
                                action="{{ route('web_release_delete', $release->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>
                            <i class="fa fa-trash btn-delete-one" onclick="deleteRelease({{ $release->id }})"></i>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="paginationWrap">
        @if (isset($releases) && count($releases) > 0)
            {{ $releases->links() }}
        @endif
    </div>

    {{-- </div> --}}
@endsection
