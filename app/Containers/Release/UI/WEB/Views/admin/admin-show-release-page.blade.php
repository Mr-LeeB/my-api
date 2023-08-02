@extends('release::layouts.admin-layout')

@section('title', 'Release')

@section('css')
    <style>
        @include('release::admin.css.admin-main-css');
    </style>
    <style>
        @include('release::admin.css.admin-show-release-css');
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
            $('#search-by-name').keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });

        function activeBody(id) {
            $('#body' + id).toggleClass('unactive');
        }

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
                              release.detail_description = release.detail_description.length > 42 ? release.detail_description.substring(0, 42).concat('...'):release.detail_description;
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
                                                       <a href="/releases/${release.id}" target="_blank">More detail</a>
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
            $('#form-sort-release').submit();
        }

        function showReleaseDetailPage(id) {
            // open in new tab
            window.open('/releases/' + id, '_blank');
        }

        function enableEdit(id) {
            window.open('/releases/' + id + '/edit', '_blank');

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
                return substr($description, 0, 37) . '...';
            }
            return $description;
        }

        function tooltip_description($id, $description)
        {
            $seeMore = '<a style="color:blue"  href="/releases/' . $id . '" target="_blank" >See more</a>';
            if (strlen($description) > 100) {
                return substr($description, 0, 100) . '...' . $seeMore;
            }
            return $description . '</br>' . $seeMore;
        }
    @endphp
@endsection


@section('content')
    <div class="content">
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
                @php
                    echo html_entity_decode(session('success'));
                @endphp
                {{ session('success') }}
            @endif
            <div class="sort">
                <form id="form-sort-release" action="{{ route('web_release_get_all_release') }}" method="GET">
                    <input type="hidden" id="orderBy" name="orderBy">
                    <input type="hidden" id="sortedBy" name="sortedBy">
                </form>
            </div>
            {{-- <div class="dropdown">
                <span>awdawd</span>
                <div class="dropdown-content">
                    <a href="#">Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                </div>
            </div> --}}
            <table>
                <thead>
                    <th><input type="checkbox" id="checkAll" onclick="checkAll({{ $releaseID_json }})"></th>
                    <th>
                        <div class="th-sort">
                            <span>ID</span>
                            <div class="sort-item">
                                <i class="fa fa-sort-asc icon-sort-item asc" aria-hidden="true"
                                    onclick="sortRelease('id','asc')"></i>
                                <i class="fa fa-sort-desc icon-sort-item" aria-hidden="true"
                                    onclick="sortRelease('id','desc')"></i>
                            </div>
                        </div>
                    </th>
                    <th>
                        <div class="th-sort">
                            <span>Name</span>
                            <div class="sort-item">
                                <i class="fa fa-sort-asc icon-sort-item asc" aria-hidden="true"
                                    onclick="sortRelease('name','asc')"></i>
                                <i class="fa fa-sort-desc icon-sort-item" aria-hidden="true"
                                    onclick="sortRelease('name','desc')"></i>
                            </div>
                        </div>
                    </th>
                    <th>
                        <div class="th-sort">
                            <span>Title</span>
                            <div class="sort-item">
                                <i class="fa fa-sort-asc icon-sort-item asc" aria-hidden="true"
                                    onclick="sortRelease('title_description','asc')"></i>
                                <i class="fa fa-sort-desc icon-sort-item" aria-hidden="true"
                                    onclick="sortRelease('title_description','desc')"></i>
                            </div>
                        </div>
                    </th>
                    <th>
                        <div class="th-sort">
                            <span>Description</span>
                            <div class="sort-item">
                                <i class="fa fa-sort-asc icon-sort-item asc" aria-hidden="true"
                                    onclick="sortRelease('detail_description','asc')"></i>
                                <i class="fa fa-sort-desc icon-sort-item" aria-hidden="true"
                                    onclick="sortRelease('detail_description','desc')"></i>
                            </div>
                        </div>
                    </th>
                    <th>
                        <div class="th-sort">
                            <span>Date Created</span>
                            <div class="sort-item">
                                <i class="fa fa-sort-asc icon-sort-item asc" aria-hidden="true"
                                    onclick="sortRelease('date_created','asc')"></i>
                                <i class="fa fa-sort-desc icon-sort-item" aria-hidden="true"
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
                                <div class="tooltip">{{ detail_description($release->detail_description) }}
                                    <span class="tooltiptext">@php echo html_entity_decode(tooltip_description($release->id, $release->detail_description)) @endphp</span>
                                </div>

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
                                <i class="fa fa-pencil btn-edit" onclick="enableEdit({{ $release->id }})"></i>
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

    </div>
@endsection
