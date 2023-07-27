<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Manager Releases</title>

    @yield('css')
</head>

<body>

    <div class="parent">
        <div class="content">
            <div class="title">
                <h1> Release page</h1>
            </div>

            {{-- <div class="create-release ">
                <form id="form-create-release" class="form-create" action="{{ route('web_release_store') }}"
                    method="POST">
                    {{ csrf_field() }}
                    <input type="text" id="name" name="name" placeholder="Name">
                    <input type="text" id="title_description" name="title_description" placeholder="Title">
                    <input type="text" id="detail_description" name="detail_description" placeholder="Description">
                    <input type="date" id="date_created" name="date_created" placeholder="Date Created"
                        value="{{ date('Y-m-d') }}">
                    <div class="is-publish-checkbox">
                        <input type="checkbox" name="is_publish" id="is_publish">
                        <label for="is_publish"> Is Publish</label>
                    </div>
                    <input type="button" value="Create new release">
                </form>
            </div> --}}
        </div>
    </div>



    @yield('js')
</body>

</html>
