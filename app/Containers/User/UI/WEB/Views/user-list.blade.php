<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Apiato</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    @yield('css')

    <!-- Scripts -->
    @yield('js')


</head>

<body>
    <div class="parent">
        <!--List all user-->
        <div class="content">
            <div class="title m-b-md">
                List Users
            </div>

            <div class="info">
                @php
                    $user = Auth::user();
                    $role = $user->roles->first();
                    $userCanCreate = false;
                    $userCanEdit = false;
                    $userCanDelete = false;

                    echo 'You are logged in as ' . $role->name . '!';
                    // show permisson in this role
                    // echo '<br />Your permission: ';
                    foreach ($role->permissions as $permission) {
                        if ($permission->name == 'create-admins') {
                            $userCanCreate = true;
                        }
                        if ($permission->name == 'update-users') {
                            $userCanEdit = true;
                        }
                        if ($permission->name == 'delete-users') {
                            $userCanDelete = true;
                        }
                        // echo $permission->name . ', ';
                    }
                @endphp

                @if ($userCanCreate)
                    @if ($errors->first('email') || $errors->first('name') || $errors->first('password'))
                        <style>
                            .create-form {
                                display: block
                            }

                            #add {
                                display: none;
                            }

                            #cancle {
                                display: block;
                            }
                        </style>
                    @endif

                    <div class="new-user">
                        <button id="add" class="btn-add" type="submit" name="createUser" method="post"
                            onclick="showCreateForm()">Add New User</button>
                        <button id="cancle" class="btn-cancle" type="submit"
                            onclick="disableCreateForm()">Cancle</button>
                        <div class="form">
                            <div id="error"></div>
                            <form class="create-form form" action="{{ route('create_new_user') }}" method="post">
                                {{ csrf_field() }}
                                @if (session('status'))
                                    <div class="text-red">{{ session('status') }}</div>
                                @endif

                                <input type="text" placeholder="email" id="email" name="email"
                                    value="{{ old('email') }}" />
                                <span class="text-red">{{ $errors->first('email') }}</span>

                                <input type="text" placeholder="name" id="name" name="name"
                                    value="{{ old('name') }}" />
                                <span class="text-red">{{ $errors->first('name') }}</span>

                                <input type="password" placeholder="password" id="password" name="password" />
                                <span class="text-red">{{ $errors->first('password') }}</span>

                                <input type="password" placeholder="confirm password" id="confirm_password" />

                                <button type="button" onclick="confirmCreate()">Create</button>
                            </form>
                        </div>
                    </div>
                @endif

                <hr>

                @php
                    // get all user id
                    $userIds = [];
                    foreach ($users as $user) {
                        if ($user->id != Auth::user()->id && $user->id != 1) {
                            array_push($userIds, $user->id);
                        }
                    }
                    $userIds = json_encode($userIds);
                    echo $userIds;

                    // echo '<br />User Ids: ' . implode(', ', $userIds);

                @endphp


                {{-- create button delete all users --}}
                @if ($userCanDelete)
                    <form class="delete-selected-form" action="{{ route('delete_user', $userIds) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button id="deleteAll" class="btn-delete-selected" type="button" name="deleteAll"
                            onclick="deleteUserSelected()">Delete Users</button>
                    </form>
                    <span>{{ $errors }}</span>
                @endif
                <table class="table table-hover">
                    <tr>
                        @if ($userCanDelete)
                            <th><input type="checkbox" id="checkAll" onclick="checkAll({{ $userIds }})" /></th>
                        @endif
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        @if ($userCanEdit)
                            @if ($userCanDelete)
                                <th colspan="2">Operation</th>
                            @else
                                <th>Operation</th>
                            @endif

                        @endif
                    </tr>
                    @foreach ($users as $user)
                        <tr>
                            @if ($userCanDelete && $user->id != 1)
                                <td style='text-align: center'>
                                    <input type="checkbox" id="select_user{{ $user->id }}"
                                        onclick="selectOne({{ $userIds }})">
                                </td>
                            @else
                                <td></td>
                            @endif
                            <td style='text-align:center;'>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>

                            @if ($userCanEdit)
                                <td style='text-align:center; '>

                                    <input id="{{ $user->id }}" type="submit"
                                        onclick="enableEdit({{ $user }})" value="Edit"
                                        style="color: #43A047; font-weight: 1000;" />

                                    <div id="myForm{{ $user->id }}" class="form-popup">
                                        <form id="edit{{ $user->id }}"
                                            class="save-form save-form{{ $user->id }}"
                                            action="{{ route('update_user', $user->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('PUT') }}
                                            @if (session('status'))
                                                <div class="text-red">{{ session('status') }}</div>
                                            @endif
                                            <table>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input style="border: none; width:15px; height:100%;"
                                                            type="text" name="id" value="{{ $user->id }}"
                                                            disabled />
                                                    </td>

                                                    <td style="width: 15rem">
                                                        <input id="name{{ $user->id }}" style="border: none"
                                                            type="text" name="name"
                                                            value="{{ $user->name }}" />
                                                        <span id="errorName{{ $user->id }}"
                                                            class="text-red">{{ $errors->first('name') }}</span>
                                                    </td>

                                                    <td style="width: 17rem">
                                                        <input style="border: none" type="text" name="email"
                                                            id="onEditEmail{{ $user->id }}"
                                                            value="{{ $user->email }}" />
                                                        <span id="errorEmail{{ $user->id }}"
                                                            class="text-red">{{ $errors->first('email') }}</span>
                                                    </td>
                                                </tr>
                                            </table>

                                            <button type="button" style="color: blue; font-weight: 1000;"
                                                onclick="confirmSave({{ $user }})">Save</button>

                                            <button type="button" style="color: red; font-weight: 1000;"
                                                onclick="cancleEdit({{ $user->id }})">Cancle</button>
                                        </form>
                                    </div>
                                </td>
                            @endif

                            @if ($userCanDelete)
                                <td style='text-align:center; '>
                                    <form id="delete{{ $user->id }}" class="delete-form{{ $user->id }}"
                                        action="{{ route('delete_user', $user->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="button" style="color: red; font-weight: 1000;"
                                            onclick="confirmDelete({{ $user->id }})">Delete</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>
            <form class="logout-form" action="{{ route('post_user_logout_form') }}" method="post"
                style="padding-bottom: 15px">
                {{ csrf_field() }}
                <button type="button" onclick="confirmlogout()">
                    Logout
                </button>
            </form>
        </div>
    </div>
</body>

</html>
