<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Logout</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
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

        .title {
            font-size: 84px;
        }

        .info {
            font-size: 24px;
            /* margin-left: 20%; */
        }

        .form {
            display: inline-block;
            margin-left: 20px;
            padding: 20px;
        }

        .form button {
            background-color: #636b6f;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .form button:hover {
            background-color: #000;
        }

        .form input {
            padding: 10px 20px;
            border-radius: 5px;
            border: 1px solid #636b6f;
            margin-bottom: 10px;
        }

        .form input:focus {
            outline: none;
        }

        .form input[type="text"] {
            width: 100%;
        }

        .form input[type="submit"] {
            background-color: #636b6f;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .form input[type="submit"]:hover {
            background-color: #000;
        }
    </style>
    <script>
        function confirmlogout() {
            if (confirm("Are you sure you want to logout?")) {
                document.getElementsByClassName("create-form")[0].submit();
            }
        }
    </script>
</head>

<body>

    @if (Auth::check())
        <div class="parent">
            <div class="content">
                <div class="info">
                    User name:
                    <span style="color: rgb(38, 6, 244)">{{ Auth::user()->name }}</span>
                </div>
                <div class="info">
                    Email:
                    <span style="color: rgb(38, 6, 244)">{{ Auth::user()->email }}</span>
                </div>
                {{-- user logout --}}
                <form class="create-form form" action="{{ route('post_user_logout_form') }}" method="post">
                    {{ csrf_field() }}
                    <button type="button" onclick="confirmlogout()">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="parent">
            <div class="content">
                <div class="info">
                    You are not logged in.
                </div>

                {{-- back to user login --}}
                <form class="create-form form" action="{{ route('get_user_login_page') }}" method="get">
                    <button type="submit">
                        login
                    </button>

            </div>
        </div>
    @endif



</body>

</html>
