@extends('user::user-list')

@section('css')
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Roboto', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .parent {

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            position: absolute;

        }

        .edit-form {
            display: block;
            /* Hidden by default */
            position: relative;
            z-index: 20;
            background: #FFFFFF;
            text-align: center;
            justify-content: center;
            align-items: top;
        }

        .content {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            width: 60%;
            border-radius: 5px;
            height: 100%;
        }

        .create-form {
            display: none;
        }

        #cancle {
            display: none;
        }

        .title {
            font-size: 84px;
        }

        .info {
            font-size: 24px;
            /* margin-left: 20%;
                                                                                                                                                                                                                                                                                                                                                                                          margin-right: 20%; */
            padding-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            border: 1px solid #ddd;
            width: 100%;
        }

        th,
        td {
            padding: 8px;
            color: #636b6f;
            font-size: 16px;
            border-right: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        th {
            background-color: #4CAF50;
            color: white;
            text-align: center;
        }

        td {
            border-bottom: 1px solid #ddd;
            font-weight: 100;
            text-align: left;


        }

        .new-user {
            text-align: left;
            margin-bottom: 10px;
            padding: 10px 0 10px;
        }

        .btn-add {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
        }

        .btn-cancle {
            background-color: #c50e0e;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
        }

        #error {
            color: red;
            margin-bottom: 10px;
        }

        .m-b-md {
            margin-bottom: 30px;
        }


        .form {
            position: relative;
            z-index: 1;
            background: #FFFFFF;
            margin: 0 auto 30px;
            text-align: center;
        }

        .form input {
            font-family: "Roboto", sans-serif;
            outline: 0;
            background: #f2f2f2;
            width: 100%;
            border: 0;
            margin: 0 0 15px;
            padding: 15px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .form button {
            font-family: "Roboto", sans-serif;
            text-transform: uppercase;
            outline: 0;
            background: #4CAF50;
            width: 100%;
            border: 0;
            padding: 15px;
            color: #FFFFFF;
            font-size: 14px;
            -webkit-transition: all 0.3 ease;
            transition: all 0.3 ease;
            cursor: pointer;
        }

        .form button:hover,
        .form button:active,
        .form button:focus {
            background: #43A047;
        }

        .form .message {
            margin: 15px 0 0;
            color: #b3b3b3;
            font-size: 12px;
        }

        .form .message a {
            color: #4CAF50;
            text-decoration: none;
        }

        .form .register-form {
            display: none;
        }

        .text-red {
            color: red;
            margin-bottom: 10px;
        }

        .new-user button:hover,
        .new-user button:active {
            background: #43A047;
        }


        .form-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .save-form {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
        }

        .save-form input {
            width: 92%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .save-form button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
        }

        .save-form button:hover,
        .save-form button:active {
            background: #43A047;
        }

        .save-form .btn-cancle {
            background-color: #c50e0e;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
        }

        .save-form .btn-cancle:hover,
        .save-form .btn-cancle:active {
            background: #c50e0e;
        }

        .save-form .text-red {
            color: red;
            margin-bottom: 10px;
        }

        .logout-form {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .logout-form button {
            background-color: #c50e0e;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
        }

        .logout-form button:hover,
        .logout-form button:active {
            background: #c50e0e;
        }

        .btn-delete-selected {
            display: none;
            background-color: #c50e0e;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
        }

        .btn-delete:hover,
        .btn-delete:active {
            background: #c50e0e;
        }
    </style>
@endsection

@section('js')
    <script>
        function confirmDelete(user) {
            if (confirm("Are you sure you want to delete this user?")) {
                // Nếu người dùng xác nhận xóa, gửi form
                document.querySelector('.delete-form' + user).submit();
            }
        }

        function enableEdit(user) {
            document.getElementById("myForm" + user.id.toString()).style.display = "block";
        }

        function confirmSave(user) {
            var confirmEditEmail = document.getElementById('onEditEmail' + user.id.toString());
            var confirmEditName = document.getElementById('name' + user.id.toString());

            if (confirmEditEmail.value.trim() == user.email.trim()) {
                confirmEditEmail.removeAttribute("name");
            }

            if (confirmEditName.value.trim() != user.name.trim() || confirmEditEmail.value.trim() != user.email.trim()) {

                if (confirm("Are you sure you want to save?")) {
                    // Nếu người dùng xác nhận xóa, gửi form
                    document.querySelector('.save-form' + user.id).submit();
                }
            }
        }

        function cancleEdit(id) {
            document.getElementById("myForm" + id).style.display = "none";
        }

        function showCreateForm() {
            document.getElementById("add").style.display = "none";
            document.getElementById("cancle").style.display = "block";
            document.querySelector('.create-form').style.display = 'block';
        }

        function disableCreateForm() {
            document.getElementById("email").value = "";
            document.getElementById("name").value = "";
            document.getElementById("password").value = "";
            document.querySelector('.create-form').style.display = 'none';
            document.getElementById("cancle").style.display = "none";
            document.getElementById("add").style.display = "block";
            document.getElementById("error").innerHTML = "";
        }

        function confirmCreate() {
            var email = document.getElementById("email").value;
            var name = document.getElementById("name").value;
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;

            if (email == "" || name == "" || password == "") {
                document.getElementById("error").innerHTML = "Please fill out all fields";
                return false;
            } else if (confirm_password == "") {
                document.getElementById("error").innerHTML = "Please confirm password";
                return false;
            } else if (password != confirm_password) {
                document.getElementById("error").innerHTML = "Password and confirm password are not the same";
                document.getElementById("confirm_password").value = "";
                return false;
            } else {
                document.getElementById("error").innerHTML = "";
                document.querySelector('.create-form').submit();
                return true;
            }
        }

        function editEmail(users, user) {
            // document.getElementById("onEditEmail" + user.id.toString()).setAttribute("name", "email");
            // users.forEach(element => {
            //     console.log(element.email);
            //     if (element.email == user.email) {
            //         document.getElementById("errorEmail" + user.id.toString()).innerHTML = "Email already exists";
            //     }
            // });
        }

        function confirmlogout() {
            if (confirm("Are you sure you want to logout?")) {
                document.getElementsByClassName("logout-form")[0].submit();
            }
        }

        function checkAll(users) {
            var check = document.getElementById("checkAll").checked;
            if (check) {
                document.getElementById("deleteAll").style.display = "block";
                users.forEach(element => {
                    document.getElementById("select_user" + element.toString()).checked = true;
                });
            } else {
                document.getElementById("deleteAll").style.display = "none";
                users.forEach(element => {
                    document.getElementById("select_user" + element.toString()).checked = false;
                });
            }
        }

        function selectOne(users) {
            var check = document.getElementById("checkAll").checked;
            var count = 0;
            users.forEach(element => {
                if (document.getElementById("select_user" + element.toString()).checked) {
                    count++;
                }
            });
            console.log(count);
            if (count == users.length) {
                document.getElementById("checkAll").checked = true;
            } else {
                document.getElementById("checkAll").checked = false;
            }
            if (count > 0) {
                document.getElementById("deleteAll").style.display = "block";
            } else {
                document.getElementById("deleteAll").style.display = "none";
            }
        }

        function deleteUserSelected() {
            if (confirm("Are you sure you want to delete users?")) {
                document.querySelector('.delete-selected-form').submit();
            }
        }
    </script>
@endsection
