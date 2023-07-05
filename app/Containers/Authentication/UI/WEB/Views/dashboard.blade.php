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
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="title">Hello World</div>
            <button onclick="window.location.href='{{ url('/listuser') }}'">List All Users</button>
            <form class="create-form form" action="{{route('post_user_logout_form')}}" method="post">
                {{ csrf_field() }}
                <button type="submit">
                    logout
                </button>
            </form>
        </div>
    </div>
</body>


</html>
