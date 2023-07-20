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
            width: 90%;
            border-radius: 5px;
            height: 100%;
        }

        table {
            border-collapse: collapse;
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
            background-color: #4CAF50;
            color: white;
        }

        a {
            text-decoration: none;
            color: #636b6f;
        }

        a:hover {
            color: #4CAF50;
        }

        .manager {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: baseline;
        }

        .role-area,
        .permission-area {
            margin: 10px;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

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
            background-color: #4CAF50;
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
            background-color: #4CAF50;
            box-shadow: 0 5px #666;
            transform: translateY(4px);
        }

        .create-form-add-role input[type='text'] {
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .create-form-add-role input[type='text']:focus {
            border: 1px solid #4CAF50;
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
            background-color: #4CAF50;
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
            background-color: #4CAF50;
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
            background-color: #4CAF50;
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

        .role-permission-area {
            margin-top: 40px;
        }

        .role-permission-area table {
            width: 50%;
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
            createForm.style.display = 'none';
        }

        function confirmCreateRole() {
            if (document.getElementById('name').value == '' || document.getElementById('display_name').value == '') {
                alert('Please fill all field');
            } else {
                if (confirm("You CAN NOT RENAME this Role. Are you sure to create this role?")) {
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

        function cancleEditPermission(id) {
            var listRolePermission = document.getElementById('list-role-permission' + id);
            var listAllPermission = document.getElementById('list-all-permission' + id);
            var groupBtnSaveCancle = document.getElementById('group-btn-save-cancle' + id);
            var btnEnableEdit = document.getElementById('btn-enable-edit' + id);


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
            <div class="manager">
                <div class="role-area">
                    <h3>Role</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Role Name</th>
                                <th>Guard Name</th>
                                <th>Display Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <form id="form-delete-role-{{ $role->id }}"
                                        action="{{ route('delete_role', $role->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <td>
                                            {{ $role->name }}
                                        </td>
                                        <td>
                                            {{ $role->guard_name }}
                                        <td>
                                            {{ $role->display_name }}
                                        </td>
                                        <td>
                                            {{ $role->description }}
                                        <td>
                                            <input class="btn-remove-role" type="button"
                                                onclick="confirmDelRole({{ $role->id }})" value="Remove">
                                        </td>
                                    </form>
                                </tr>
                            @endforeach

                            <form action="{{ route('create_role') }}" method="POST" id="form-create-role">
                                {{ csrf_field() }}
                                <tr class="create-form-add-role">
                                    <td>
                                        <input type="text" name="name" id="name" placeholder="Role Name">
                                    </td>
                                    <td>
                                        <input type="text" name="guard_name" id="guard_name" value="web">
                                    <td>
                                        <input type="text" name="display_name" id="display_name"
                                            placeholder="Display Name">
                                    </td>
                                    <td>
                                        <input type="text" name="description" id="description"
                                            placeholder="Description">
                                    </td>
                                    <td>
                                        <input class="btn-confirm-create-role" type="button"
                                            onclick="confirmCreateRole()" value="Save">
                                        <input class="btn-cancle-create-role" type="button"
                                            onclick="cancleCreateRole()" value="Cancle">
                                    </td>
                                </tr>
                            </form>
                            <tr>
                                <td colspan="4" style="text-align: center; width: fit-content">
                                    <input class="btn-create-role" type="button" onclick="createNewRole()"
                                        value="Add New Role">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="permission-area">
                    <h3>Permission</h3>
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
                                    <td class="list-role-permission" id="list-role-permission{{ $role->id }}">
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
                                                    <input class="permission-item"
                                                        id="permission-attach-ids{{ $permission->id }}{{ $role->id }}"
                                                        type="checkbox" value="{{ $permission->id }}"
                                                        @if ($role->permissions->contains($permission->id)) checked @endif>
                                                    {{ $permission->name }}
                                                </div>
                                            @endforeach
                                        </form>
                                    </td>
                                    <td>
                                        <input class="btn-enable-edit" id="btn-enable-edit{{ $role->id }}"
                                            type="button" onclick="enableEditPermission({{ $role->id }})"
                                            value="Edit">

                                        <div class="group-btn-save-cancle"
                                            id="group-btn-save-cancle{{ $role->id }}">
                                            <input class="btn-save-permission" type="button"
                                                onclick="confirmSavePermission({{ $role->id }}, {{ json_encode($permissionIDs) }}, {{ json_encode($permissionRoleIDs) }})"
                                                value="Save">
                                            <input class="btn-cancle-permission" type="button"
                                                onclick="cancleEditPermission({{ $role->id }})" value="Cancle">
                                        </div>
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
</body>

</html>
