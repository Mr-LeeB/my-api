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
                <h1>Products</h1>
            </div>
            <div class="create-new-product">
                <form action="{{ route('web_get_product_create_page') }}" method="GET">
                    <input type="submit" class="btn-create" value="Create new product">
                </form>
            </div>
            <div class="links">
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Image</th>
                        </tr>
                    </thead>

                    @php
                        $product_description = [];
                        foreach ($products as $key => $value) {
                            if (strlen($value->description) > 20) {
                                $value->description = substr($value->description, 0, 20) . '...';
                            }
                            array_push($product_description, $value);
                        }
                    @endphp

                    <tbody>
                        @foreach ($product_description as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td><img src="{{ asset($product->image) }}" alt="" width=""></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</body>

</html>
