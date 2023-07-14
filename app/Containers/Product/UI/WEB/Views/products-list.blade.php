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

    {{-- php function --}}
    @php
        $product_description = [];
        $productID_json = [];
        foreach ($products as $key => $value) {
            if (strlen($value->description) > 20) {
                $value->description = substr($value->description, 0, 20) . '...';
            }
            array_push($product_description, $value);
            array_push($productID_json, $value->id);
        }

        $productID_json = json_encode($productID_json);
    @endphp

</head>

<body>
    @include('product::menu')

    <div class="parent">

        <!--List all products-->
        <div class="content">

            <div class="title m-b-md">
                <h1>Products</h1>
            </div>
            <div
                style="
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;">
                <div class="create-new-product">
                    <form action="{{ route('web_get_product_create_page') }}" method="GET">
                        <input type="submit" class="btn-create" value="Create new product">
                    </form>
                </div>
                <div class="search-area">
                    <input class="input-search" type="text" name="search" placeholder="Search product"
                        oninput="searchByNameProduct()">
                </div>
            </div>


            @if (session('message'))
                <span> {{ session('message') }}</span>
            @endif


            <script></script>
            <div class="links">

              <script>
                function confirmDeleteMoreProduct() {
                    var id = document.getElementById('id').value;
                    var form = document.getElementById('form-delete-more-product');
                    var r = confirm("Are you sure you want to delete this product?");
                    if (r == true) {
                        form.submit();
                    }
                }
              </script>

              <div class="delete-more-product">
                <form action="" method="POST" id="form-delete-more-product">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <input type="hidden" name="id" id="id">
                    <input type="button" onclick="confirmDeleteMoreProduct()" class="btn-delete" value="Delete">
                </form>
              </div>

                <table>
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll" onclick="checkAll({{ $productID_json }})" /></th>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th colspan="2">Operation</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($product_description as $product)
                            <tr id="{{ $product->id }}">
                                <td>
                                    <input type="checkbox" id="select_product{{ $product->id }}"
                                        onclick="checkOne({{ $productID_json }})">
                                </td>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td><img src="{{ asset($product->image) }}" alt="" width=""></td>
                                <td class="operation">
                                    <form action="{{ route('web_product_find_by_id', $product->id) }}" method="GET">
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                        <input type="submit" class="btn-edit" value="More Detail">
                                    </form>

                                </td>
                                <td class="operation">
                                    <form class="form-detele-product" id="form-detele-product{{ $product->id }}"
                                        action="{{ route('web_product_delete', $product->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                        <input type="button" onclick="confirmDeleteProduct({{ $product->id }})"
                                            class="btn-delete" value="Delete">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
