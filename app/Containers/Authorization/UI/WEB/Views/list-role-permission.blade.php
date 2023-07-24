<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manager Role - Permission</title>

    <style>
        html,
        body {
            background-color: #fff;
            color: #000000;
            font-family: 'Roboto', sans-serif;
            font-weight: 100;
            height: fit-content;
            margin: 0;
        }

        .parent {

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        .content {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            width: 100%;
            border-radius: 5px;
            height: 100%;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 15px;
            text-align: center;
        }

        th {
            background-color: #201ea6;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        a {
            text-decoration: none;
            color: #636b6f;
        }

        a:hover {
            color: #342ed2;
        }

        .managers {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-start;
        }

        .manager {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: baseline;
            width: 70%;
        }

        .role-permission-area {
            width: 30%;
        }

        .role-area,
        .permission-area,
        .role-permission-area {
            margin: 5px;
            padding: 5px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: #2313ad solid 4px;
        }

        .create-form-add-role {
            display: none;
        }

        .create-form-add-role td {
            padding: 5px;
        }

        .create-form-add-role input {
            width: 80%;
            padding: 5px;
        }

        .btn-confirm-create-role {
            background-color: #201ea6;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin: 2px 2px;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-cancle-create-role {
            background-color: #f44336;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin: 2px 2px;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-confirm-create-role:hover,
        .btn-cancle-create-role:hover {
            background-color: #2f1d79;
        }

        .btn-confirm-create-role:active,
        .btn-cancle-create-role:active {
            background-color: #201ea6;
            box-shadow: 0 5px #666;
            transform: translateY(4px);
        }

        .create-form-add-role input[type='text'],
        .create-form-add-role input[type='number'] {
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .create-form-add-role input[type='text']:focus,
        .create-form-add-role input[type='number']:focus {
            border: 1px solid #201ea6;
        }

        .btn-remove-role {
            background-color: #f44336;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin: 2px 2px;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-remove-role:hover {
            background-color: #2f1d79;
        }

        .btn-create-role {
            background-color: #201ea6;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin: 2px 2px;
            cursor: pointer;
            border-radius: 4px;
            width: 100%;
            height: 100%;
        }

        .btn-create-role:hover {
            background-color: #2f1d79;
        }

        .list-role-permission {
            text-align: left;
        }

        .list-all-permission {
            display: none;
            text-align: left;
        }

        .group-btn-save-cancle {
            display: none;
        }

        .btn-save-permission {
            background-color: #201ea6;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin: 2px 2px;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-save-permission:hover {
            background-color: #2f1d79;
        }

        .btn-cancle-permission {
            background-color: #f44336;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin: 2px 2px;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-cancle-permission:hover {
            background-color: #2f1d79;
        }

        .permission-id-item {
            margin: 5px;

            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-items: center;

        }

        .permission-item {
            margin-right: 5px;
            width: 18px;
            height: 18px;
        }

        .permission-item:hover {
            background-color: #2f1d79;
        }

        .permission-item:active {
            transform: translateY(2px);
            box-sizing: border-box;
        }

        .btn-enable-edit {
            background-color: #201ea6;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin: 2px 2px;
            cursor: pointer;
            border-radius: 4px;


        }

        .btn-enable-edit:hover {
            background-color: #2f1d79;
        }


        .input-edit {
            width: 100%;
            border: none;
            background-color: transparent;
        }

        .btn-edit-role {
            background-color: #201ea6;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: block;
            font-size: 12px;
            margin: 2px 2px;
            cursor: pointer;
            border-radius: 4px;
            width: 100%;
        }

        .btn-edit-role:hover {
            background-color: #2f1d79;
        }

        .btn-edit-role:active {
            transform: translateY(2px);
            box-sizing: border-box;
        }

        .errorCreate,
        .errorCreateP {
            color: red;
            font-size: 12px;
        }

        .td-create-input {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function createNewRole() {
            var createForm = document.getElementsByClassName('create-form-add-role')[0];
            createForm.style.display = 'table-row';
        }

        function cancleCreateRole() {
            var createForm = document.getElementsByClassName('create-form-add-role')[0];
            document.getElementById('name').value = '';
            document.getElementById('display_name').value = '';
            document.getElementById('description').value = '';
            document.getElementById('level').value = '0';
            var errorCreate = document.getElementsByClassName('errorCreate');
            for (var i = 0; i < errorCreate.length; i++) {
                errorCreate[i].innerHTML = '';
            }
            createForm.style.display = 'none';
        }

        function confirmCreateRole() {
            if (document.getElementById('name').value == '' || document.getElementById('display_name').value == '') {
                alert('Please fill all field');
            } else {
                if (confirm("Are you sure to create this role?")) {
                    document.getElementById('form-create-role').submit();
                }
            }
        }

        function confirmDelRole(id) {
            if (confirm("Are you sure to delete this role?")) {
                document.getElementById('form-delete-role-' + id).submit();
            }
        }

        function enableEditPermission(roleId) {
            var listRolePermission = document.getElementById('list-role-permission' + roleId);
            var listAllPermission = document.getElementById('list-all-permission' + roleId);
            var groupBtnSaveCancle = document.getElementById('group-btn-save-cancle' + roleId);
            var btnEnableEdit = document.getElementById('btn-enable-edit' + roleId);

            btnEnableEdit.style.display = 'none';
            listRolePermission.style.display = 'none';
            listAllPermission.style.display = 'table-cell';
            groupBtnSaveCancle.style.display = 'block';
        }

        function cancleEditPermission(id, listPermissions) {
            var listRolePermission = document.getElementById('list-role-permission' + id);
            var listAllPermission = document.getElementById('list-all-permission' + id);
            var groupBtnSaveCancle = document.getElementById('group-btn-save-cancle' + id);
            var btnEnableEdit = document.getElementById('btn-enable-edit' + id);

            // reset lại các checkbox
            var permissionIDs = document.getElementsByClassName('permission-item' + id);
            for (var i = 0; i < permissionIDs.length; i++) {
                permissionIDs[i].checked = false;
                for (var j = 0; j < listPermissions.length; j++) {
                    if (permissionIDs[i].value == listPermissions[j].id) {
                        permissionIDs[i].checked = true;
                    }
                    console.log(listPermissions[j].id)
                }
            }

            btnEnableEdit.style.display = 'inline-block';
            listRolePermission.style.display = 'table-cell';
            listAllPermission.style.display = 'none';
            groupBtnSaveCancle.style.display = 'none';
        }

        function confirmSavePermission(roleID, permissionIDs, permissionRoleIDs) {
            //khai báo flag để kiểm tra xem có permission nào cần detach không
            var havePermissionDetach = false;

            //duyệt qua tất cả các permission có trong database
            permissionIDs.forEach(permissionID => {
                var permissionCheckbox = document.getElementById('permission-attach-ids' + permissionID + roleID);
                //nếu có permission nào không được check thì thực hiện kiểm tra trước khi detach permission đó
                if (permissionRoleIDs[0] == null) {
                    if (permissionCheckbox.checked) {
                        permissionCheckbox.setAttribute('name', "permissions_ids[]");
                        console.log("attach permission in new role " + permissionID);
                    }
                } else {
                    if (!permissionCheckbox.checked) {
                        var permissionDetach = document.getElementById('permission-detach-ids' + permissionID +
                            roleID);
                        //kiểm tra xem permission không được check có trong danh sách permission của role không
                        permissionRoleIDs.forEach(permissionRoleID => {
                            //nếu có thì thêm vào form detach permission
                            if (permissionRoleID == permissionID) {
                                permissionDetach.setAttribute('name', "permissions_ids[]");
                                havePermissionDetach = true;
                                console.log("detach permission " + permissionID);
                            }
                        });
                    }
                    //nếu có permission nào được check thì thực hiện kiểm tra trước khi attach permission đó
                    else {
                        //kiểm tra xem permission được check có trong danh sách permission của role không
                        var count = 0;
                        permissionRoleIDs.forEach(permissionRoleID => {
                            //nếu không có thì thêm vào form attach permission
                            if (permissionRoleID == permissionID) {
                                count++;
                            }
                        });
                        if (!count) {
                            permissionCheckbox.setAttribute('name', "permissions_ids[]");
                            console.log("attach permission " + permissionID);
                        }
                    }
                }
            });

            if (confirm("Are you sure you want to save?")) {
                if (havePermissionDetach) {
                    jQuery.ajax({
                        type: 'post',
                        url: "{{ url('authorization/roles/detach') }}",
                        data: $('#form-detach-permission-to-role' + roleID.toString()).serialize(),
                        success: function(data) {
                            console.log(data);
                        },
                        error: function(data) {
                            alert('error');
                        }
                    });
                }
                document.querySelector('#form-attach-permission-to-role' + roleID).submit();
            }
        }

        function enableEditRole(id, roleName) {
            var name = document.getElementById('name' + id);
            var displayName = document.getElementById('display_name' + id);
            var description = document.getElementById('description' + id);
            var level = document.getElementById('level' + id);
            var btnUpdateRole = document.getElementById('btn-edit-role' + id);
            var btnDeleteRole = document.getElementById('btn-delete-role' + id);

            name.disabled = false;
            name.style.border = '1px solid #000';
            name.style.borderRadius = '4px';
            displayName.disabled = false;
            displayName.style.border = '1px solid #000';
            displayName.style.borderRadius = '4px';
            description.disabled = false;
            description.style.border = '1px solid #000';
            description.style.borderRadius = '4px';
            level.disabled = false;
            level.style.border = '1px solid #000';
            level.style.borderRadius = '4px';
            btnUpdateRole.value = 'Save';
            btnUpdateRole.setAttribute('onclick', 'confirmUpdateRole(' + id + ', "' + roleName.toString() + '")');

            btnDeleteRole.value = 'Cancle';
            btnDeleteRole.setAttribute('onclick', 'cancleUpdateRole(' + id + ', "' + roleName.toString() + '")');
        }

        function cancleUpdateRole(id, roleName) {
            var name = document.getElementById('name' + id);
            var displayName = document.getElementById('display_name' + id);
            var description = document.getElementById('description' + id);
            var level = document.getElementById('level' + id);
            var btnUpdateRole = document.getElementById('btn-edit-role' + id);
            var btnDeleteRole = document.getElementById('btn-delete-role' + id);


            name.disabled = true;
            name.style.border = 'none';
            displayName.disabled = true;
            displayName.style.border = 'none';
            description.disabled = true;
            description.style.border = 'none';
            level.disabled = true;
            level.style.border = 'none';
            btnUpdateRole.value = 'Edit';
            btnUpdateRole.setAttribute('onclick', 'enableEditRole(' + id + ', "' + roleName.toString() + '")');

            btnDeleteRole.value = 'Remove';
            btnDeleteRole.setAttribute('onclick', 'confirmDelRole(' + id + ')');
        }

        function confirmUpdateRole(id, roleName) {
            var name = document.getElementById('name' + id);
            var displayName = document.getElementById('display_name' + id);
            var description = document.getElementById('description' + id);
            var level = document.getElementById('level' + id);
            var btnUpdateRole = document.getElementById('btn-edit-role' + id);
            var btnDeleteRole = document.getElementById('btn-delete-role' + id);

            if (name.value == '' || displayName.value == '') {
                alert('Please fill all field');
                return;
            } else {
                if (name.value.trim() == roleName.trim()) {
                    name.removeAttribute('name');
                    console.log(name.name);
                }
            }
            if (confirm("Are you sure to update this role?")) {
                document.querySelector('#form-update-role' + id).submit();
            }
        }
    </script>

    {{-- php function --}}

    @php
        $permissionIDs = [];
        foreach ($permissions as $permission) {
            array_push($permissionIDs, $permission->id);
        }
    @endphp
</head>

<body>
    @include('product::menu')
    <div class="parent">
        <div class="content">
            <h1>Manager Role - Permission</h1>
            <hr>
            <div class="managers">
                <div class="manager">
                    <div class="role-area">
                        <h2>Role</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Role Name</th>
                                    <th>Guard Name</th>
                                    <th>Display Name</th>
                                    <th>Description</th>
                                    <th>Level</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $key => $role)
                                    <tr>
                                        <form id="form-delete-role-{{ $role->id }}"
                                            action="{{ route('delete_role', $role->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                        <form id="form-update-role{{ $role->id }}" name="form-update-role"
                                            action="{{ route('update_role', $role->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('PUT') }}
                                            <td>
                                                <input class="input-edit" id="name{{ $role->id }}" type="text"
                                                    name="name" value="{{ $role->name }}" disabled>
                                            </td>
                                            <td>
                                                <input class="input-edit" type="text"
                                                    value=" {{ $role->guard_name }}" disabled>
                                            <td>
                                                <input class="input-edit" id="display_name{{ $role->id }}"
                                                    type="text" name="display_name"
                                                    value="{{ $role->display_name }}" disabled>
                                            </td>
                                            <td>
                                                <input class="input-edit" id="description{{ $role->id }}"
                                                    type="text" name="description" value="{{ $role->description }}"
                                                    disabled>
                                            </td>
                                            <td>
                                                <input class="input-edit" id="level{{ $role->id }}" type="number"
                                                    name="level" value="{{ $role->level }}" disabled>
                                            </td>
                                            <td>
                                                <input id="btn-edit-role{{ $role->id }}" class="btn-edit-role"
                                                    type="button"
                                                    onclick="enableEditRole({{ $role->id }}, {{ json_encode($role->name) }})"
                                                    value="Edit">
                                            </td>
                                            <td>
                                                <input id="btn-delete-role{{ $role->id }}" class="btn-remove-role"
                                                    type="button" onclick="confirmDelRole({{ $role->id }})"
                                                    value="Remove">
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach

                                <form action="{{ route('create_role') }}" method="POST" id="form-create-role">
                                    {{ csrf_field() }}
                                    <tr class="create-form-add-role">
                                        @php
                                            $nameR = '';
                                            $display_nameR = '';
                                            $descriptionR = '';
                                            
                                            $errorNameR = '';
                                            $errorDisplayNameR = '';
                                            $errorDescriptionR = '';
                                            
                                            if ($errors->any()) {
                                                if (old('level') != null) {
                                                    $nameR = old('name');
                                                    $display_nameR = old('display_name');
                                                    $descriptionR = old('description');
                                            
                                                    $errorNameR = $errors->first('name');
                                                    $errorDisplayNameR = $errors->first('display_name');
                                                    $errorDescriptionR = $errors->first('description');
                                                }
                                            }
                                            
                                        @endphp
                                        <td>
                                            <div class="td-create-input">
                                                <input type="text" name="name" id="name"
                                                    placeholder="Role Name" value="{{ $nameR }}">
                                                @if ($errors->has('name'))
                                                    <span class="errorCreate"> {{ $errorNameR }} </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="td-create-input">
                                                <input type="text" id="guard_name" value="web" disabled>

                                            </div>
                                        <td>
                                            <div class="td-create-input">
                                                <input type="text" name="display_name" id="display_name"
                                                    placeholder="Display Name" value="{{ $display_nameR }}">
                                                @if ($errors->has('display_name'))
                                                    <span class="errorCreate"> {{ $errorDisplayNameR }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="td-create-input">
                                                <input type="text" name="description" id="description"
                                                    placeholder="Description" value="{{ $descriptionR }}">
                                                @if ($errors->has('description'))
                                                    <span class="errorCreate"> {{ $errorDescriptionR }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $level = 0;
                                                if (old('level')) {
                                                    $level = old('level');
                                                }
                                            @endphp
                                            <div class="td-create-input">
                                                <input type="number" name="level" id="level" placeholder="Level"
                                                    value="{{ $level }}">
                                                @if ($errors->has('level'))
                                                    <span class="errorCreate"> {{ $errors->first('level') }} </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <input class="btn-confirm-create-role" type="button"
                                                onclick="confirmCreateRole()" value="Save">
                                        </td>
                                        <td>
                                            <input class="btn-cancle-create-role" type="button"
                                                onclick="cancleCreateRole()" value="Cancle">
                                        </td>
                                    </tr>
                                </form>
                                <tr>
                                    <td colspan="5" style="text-align: center; width: fit-content">
                                        <input class="btn-create-role" type="button" onclick="createNewRole()"
                                            value="Add New Role">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="permission-area">
                        <h2>Permission</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Permission Name</th>
                                    <th>Guard Name</th>
                                    <th>Display Name</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>
                                            {{ $permission->name }}
                                        </td>
                                        <td>
                                            {{ $permission->guard_name }}
                                        <td>
                                            {{ $permission->display_name }}
                                        </td>
                                        <td>
                                            {{ $permission->description }}
                                        </td>

                                    </tr>
                                @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="role-permission-area">
                    <h2>Role - Permission</h2>
                    <div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Role</th>
                                    <th>Permission</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    @php
                                        $permissionRoleIDs = [];
                                        foreach ($role->permissions as $permissionRole) {
                                            array_push($permissionRoleIDs, $permissionRole->id);
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        <td class="list-role-permission"
                                            id="list-role-permission{{ $role->id }}">
                                            @foreach ($role->permissions as $permission)
                                                {{ $permission->name }} <br>
                                            @endforeach
                                        </td>
                                        <td class="list-all-permission" id="list-all-permission{{ $role->id }}">
                                            <form id="form-attach-permission-to-role{{ $role->id }}"
                                                action="{{ route('attach_permission_to_role') }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="role_id" value="{{ $role->id }}">
                                                @foreach ($permissions as $permission)
                                                    <div class="permission-id-item">
                                                        <input
                                                            class="permission-item permission-item{{ $role->id }}"
                                                            id="permission-attach-ids{{ $permission->id }}{{ $role->id }}"
                                                            type="checkbox" value="{{ $permission->id }}"
                                                            @if ($role->permissions->contains($permission->id)) checked @endif>
                                                        {{ $permission->name }}
                                                    </div>
                                                @endforeach
                                            </form>
                                            <div class="group-btn-save-cancle"
                                                id="group-btn-save-cancle{{ $role->id }}">
                                                <input class="btn-save-permission" type="button"
                                                    onclick="confirmSavePermission({{ $role->id }}, {{ json_encode($permissionIDs) }}, {{ json_encode($permissionRoleIDs) }})"
                                                    value="Save">
                                                <input class="btn-cancle-permission" type="button"
                                                    onclick="cancleEditPermission({{ $role->id }}, {{ json_encode($role->permissions) }})"
                                                    value="Cancle">
                                            </div>
                                        </td>
                                        <td>
                                            <input class="btn-enable-edit" id="btn-enable-edit{{ $role->id }}"
                                                type="button" onclick="enableEditPermission({{ $role->id }})"
                                                value="Edit">
                                        </td>
                                    </tr>
                                    <form action="{{ route('detach_permission_to_role') }}" method="POST"
                                        id="form-detach-permission-to-role{{ $role->id }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="role_id" value="{{ $role->id }}">
                                        @foreach ($permissionIDs as $permissionID)
                                            <input type="hidden"
                                                id="permission-detach-ids{{ $permissionID }}{{ $role->id }}"
                                                value="{{ $permissionID }}">
                                        @endforeach
                                    </form>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        if ({{ $errors->any() }}) {
            if ({{ old('level') }} != null) {
                createNewRole();
            } else {
                createNewPermission();
            }
        }
    </script>
</body>

</html>
