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
    @include('product::menu')

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
                    {{-- @if ($errors->first('email') || $errors->first('name') || $errors->first('password')) --}}
                    @if (old('isEdited') == -1)
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

                            .errorEmailCreate,
                            .errorNameCreate,
                            .errorPasswordCreate {
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
                                    value="<?php if (old('isEdited') == -1) {
                                        echo old('email');
                                    } ?>" oninput="changeEmailRegister()" />

                                <span class="text-red errorEmailCreate">{{ $errors->first('email') }}</span>

                                <input type="text" placeholder="name" id="name" name="name"
                                    value="<?php if (old('isEdited') == -1) {
                                        echo old('name');
                                    } ?>" oninput="changeNameRegister()" />

                                <span class="text-red errorNameCreate">{{ $errors->first('name') }}</span>

                                <input type="password" placeholder="password" id="password" name="password" />

                                <span class="text-red errorPasswordCreate">{{ $errors->first('password') }}</span>

                                <input type="password" placeholder="confirm password" id="confirm_password" />

                                <input type="hidden" name="isEdited" value="-1" />

                                <button type="button" onclick="confirmCreate()">Create</button>
                            </form>
                        </div>
                    </div>
                @endif

                <hr>

                @php
                    // get all user ids, user emails
                    $userIds = [];
                    $userEmails = [];
                    foreach ($users as $user) {
                        if ($user->id != Auth::user()->id && $user->id != 1) {
                            array_push($userIds, $user->id);
                        }
                        array_push($userEmails, $user->email);
                    }
                    $userIds_json = json_encode($userIds);
                    $usersEmails_json = json_encode($userEmails);

                @endphp


                {{-- create button delete all users --}}
                @if ($userCanDelete)
                    <form class="delete-selected-form" action="{{ route('delete_more_users') }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        @foreach ($userIds as $item)
                            <input id="selectUser{{ $item }}" type="hidden" name="ids[]"
                                value="{{ $item }}" />
                        @endforeach

                        <button id="deleteAll" class="btn-delete-selected" type="button" name="deleteAll"
                            onclick="deleteUserSelected({{ $userIds_json }})">Delete Users</button>
                    </form>
                @endif

                <table class="table table-hover">
                    <tr>
                        @if ($userCanDelete)
                            <th><input type="checkbox" id="checkAll" onclick="checkAll({{ $userIds_json }})" /></th>
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
                        @else
                            @if ($userCanDelete)
                                <th>Operation</th>
                            @endif
                        @endif
                    </tr>
                    @foreach ($users as $user)
                        <tr>
                            @if ($userCanDelete && $user->id != 1 && $user->id != Auth::user()->id)
                                <td style='text-align: center'>
                                    <input type="checkbox" id="select_user{{ $user->id }}"
                                        onclick="selectOne({{ $userIds_json }})">
                                </td>
                            @else
                                @if ($userCanDelete)
                                    <td></td>
                                @endif
                            @endif
                            <td style='text-align:center;'>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>

                            @if ($userCanEdit)
                                @if (old('isEdited') == $user->id)
                                    <style>
                                        #errorName<?php echo $user->id; ?>,
                                        #errorEmail<?php echo $user->id; ?>,
                                        #myForm<?php echo $user->id; ?> {
                                            display: block;
                                        }
                                    </style>
                                @endif
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
                                            <input type="hidden" name="isEdited" value="{{ $user->id }}">
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
                                                            value="<?php
                                                            if (old('isEdited') == $user->id && old('name')) {
                                                                echo old('name');
                                                            } else {
                                                                echo $user->name;
                                                            }
                                                            ?>" />
                                                        <span id="errorName{{ $user->id }}"
                                                            class="text-red errorName">{{ $errors->first('name') }}</span>
                                                    </td>

                                                    <td style="width: 17rem">
                                                        <input id="onEditEmail{{ $user->id }}"
                                                            style="border: none" type="text" name="email"
                                                            oninput="editEmail({{ $usersEmails_json }}, {{ $user }})"
                                                            value="<?php
                                                            if (old('isEdited') == $user->id && old('email')) {
                                                                echo old('email');
                                                            } else {
                                                                echo $user->email;
                                                            }
                                                            ?>" />
                                                        <span id="errorEmail{{ $user->id }}"
                                                            class="text-red errorEmail">{{ $errors->first('email') }}</span>
                                                    </td>
                                                </tr>
                                            </table>

                                            <button class="edit-save" type="button"
                                                style="color: blue; font-weight: 1000;"
                                                onclick="confirmSave({{ $user }})">Save</button>

                                            <button class="edit-cancle" type="button"
                                                style="color: red; font-weight: 1000;"
                                                onclick="cancleEdit({{ $user }})">Cancle</button>
                                        </form>
                                    </div>
                                </td>
                            @endif

                            @if ($userCanDelete)
                                <td style='text-align:center; '>
                                    @if ($user->id == 1 || $user->id == Auth::user()->id)
                                        <button type="button" style="color: red; font-weight: 1000;"
                                            onclick="confirmDelete({{ $user->id }})" disabled>Delete</button>
                                    @else
                                        <form id="delete{{ $user->id }}" class="delete-form{{ $user->id }}"
                                            action="{{ route('delete_user', $user->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="button" style="color: red; font-weight: 1000;"
                                                onclick="confirmDelete({{ $user->id }})">Delete</button>
                                        </form>
                                    @endif
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

            <form id="removeAccount-form" class="removeAccount"
                action="{{ route('delete_user', Auth::user()->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <input id="passwordRemoveAccount" type="password"
                    placeholder="Please enter your password to remove your account">
                {{-- <span class="text-red errorPasswordRemoveAccount">{{ $errors }}</span> --}}
                <button class="btn-remove-account" id="enterRemoveAccount" type="button"
                    onclick="confirmRemoveAccount()">
                    Remove Your Account</button>
            </form>

            <form action="{{ url('check-password') }}" method="POST" id="checkpassword" style="display: none">
                @csrf
                <input id="thispass" type="hidden" name="password">
                {{-- <input type="hidden" name="authpassword" id="authpassword" value="{{ Auth::user()->password }}"> --}}
            </form>
        </div>
    </div>
</body>

</html>
