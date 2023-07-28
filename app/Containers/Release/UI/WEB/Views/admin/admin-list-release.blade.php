<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Manager Releases</title>

    @yield('css')
    @yield('php')

</head>

<body>
    @include('release::header.header')
    <div class="body">
        @include('release::menu.menu')
        <div class="parent">
            <div class="content">
                <div class="title">
                    <h1> Release Manage</h1>
                </div>


                <div class="create-seach-area">

                    <div class="create-release">
                        <h2>Create new release</h2>
                        <form id="form-create-release" class="form-create" action="{{ route('web_release_store') }}"
                            method="POST">
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
                    <div class="search-area">
                        <h2>Search release</h2>
                        <div class="search">
                            <form class="form-search" id="form-search-release" action="" method="POST">
                                {{ csrf_field() }}
                                <input type="text" name="name" id="search-by-name" placeholder="Search"
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
                    <form action="" method="POST" id="form-delete-more-release">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        @foreach ($releaseID as $id)
                            <input type="hidden" name="id[]" id="selectedManyReleaseToDel{{ $id }}"
                                value="{{ $id }}">
                        @endforeach
                        <input type="button" onclick="confirmDeleteMoreRelease({{ $releaseID_json }})"
                            class="btn-delete" value="Delete Releases">
                    </form>
                </div>
                <div class="table-list-all-release">
                    <table>
                        <thead>
                            <th><input type="checkbox" id="checkAll" onclick="checkAll({{ $releaseID_json }})"></th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date Created</th>
                            <th>Is Publish</th>
                            <th colspan="2">Actions</th>
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
                                    @if (strlen($release->detail_description) > 40)
                                        <td>{{ substr($release->detail_description, 0, 40) }}...</td>
                                    @else
                                        <td>{{ $release->detail_description }}</td>
                                    @endif
                                    <td style="text-align: center;">{{ $release->date_created }}</td>
                                    <td style="text-align: center;">{{ $release->is_publish }}</td>
                                    <td style="text-align: center;">
                                        <input class="btn-edit" type="button" id="edit-release-{{ $release->id }}"
                                            onclick="enableEdit({{ $release->id }})" value="Edit">
                                    </td>
                                    <td style="text-align: center;">
                                        <input class="btn-delete" type="button"
                                            id="delete-release-{{ $release->id }}"
                                            onclick="deleteRelease({{ $release->id }})" value="Delete">
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
        </div>
    </div>

    <div class="footer">
        @include('release::footer.footer')
    </div>

    @yield('js')
</body>

</html>
