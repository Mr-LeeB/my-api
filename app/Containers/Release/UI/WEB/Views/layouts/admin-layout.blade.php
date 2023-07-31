<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>@yield('title') - Apiato</title>
    @yield('css')
</head>

<body>
    @yield('header')


    <main>
        <div class="body">
            @yield('menu')
            <div class="parent">
                @yield('content')
            </div>
        </div>
    </main>
    <div class="footer">
        @include('release::footer.footer')
    </div>
</body>
@yield('php')

@yield('js')

</html>
