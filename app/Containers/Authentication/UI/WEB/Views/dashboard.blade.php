<!DOCTYPE html>
<html>

<head>
    <title>Apiato</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 100px;
            color: #00bdf4;
        }

        .list-users {
            font-size: 30px;
            color: #00bdf4;
            background-color: #fff;
            border: 1px solid #00bdf4;
            border-radius: 5px;
            padding: 10px;
            margin-top: 20px;
            cursor: pointer;
        }

        .list-users:hover {
            background-color: #00bdf4;
            color: #fff;
        }

        .form {
            position: relative;
            z-index: 1;
            background: #FFFFFF;
            max-width: 360px;
            margin: 0 auto 100px;
            padding: 45px;
            text-align: center;
        }

        .form button {
            font-family: "Roboto", sans-serif;
            text-transform: uppercase;
            outline: 0;
            background: #a52424;
            width: 100%;
            border: 0;
            padding: 15px;
            color: #FFFFFF;
            font-size: 14px;
            -webkit-transition: all 0.3 ease;
            transition: all 0.3 ease;
            cursor: pointer;
            border-radius: 5px;
        }

        .form button:hover,
        .form button:active,
        .form button:focus {
            background: #43A047;
        }
    </style>
    <script>
        function confirmLogout() {

            if (confirm("Are you sure you want to logout?")) {
                document.querySelector('.form').submit();
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="content">

            {{-- <div class="title">Hello World</div> --}}
            <button class="list-users" onclick="window.location.href='{{ url('/listuser') }}'">List All Users</button>
            <form class="form" action="{{ route('post_user_logout_form') }}" method="post">
                {{ csrf_field() }}
                <button type="button" onclick="confirmLogout()">
                    logout
                </button>
            </form>
        </div>
    </div>
</body>

</html>
