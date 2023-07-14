<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add New Product</title>
</head>

<style>
    html,
    body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Roboto', sans-serif;
        font-weight: 100;
        height: 100%;
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
        width: 60%;
        border-radius: 5px;
        height: 100%;
    }

    .add-new-product {
        text-align: center;
        justify-content: center;
        margin: 20px 0;
        padding: 20px;
        border-radius: 5px;
        border: #636b6f 1px solid;
    }

    .back-to-list {
        text-align: left;
    }

    a {
        text-decoration: none;
        color: #411df3;
        font-size: 18px;
    }

    a:hover {
        color: #9b2d2d;
    }

    form {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    input {
        margin-bottom: 10px;
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    button {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
        background-color: #9b2d2d;
        color: white;
        font-size: 18px;
        font-weight: bold;
    }

    button:hover {
        background-color: #7a1f1f;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #ddd;
        font-size: 18px;
    }

    table th,
    table td {
        text-align: left;
        padding: 16px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2
    }

    tr:hover {
        background-color: #ddd;
    }

    th {
        background-color: #9b2d2d;
        color: white;
    }

    .btn-create {
        background-color: #9b2d2d;
        color: white;
        font-size: 18px;
        font-weight: bold;
    }

    .btn-create:hover {
        background-color: #7a1f1f;
    }
</style>

<script>
    function confirmCreateNewProduct() {
        var name = document.getElementById('name').value;
        var description = document.getElementById('description').value;
        var image = document.getElementById('image').value;

        if (name == '' || description == '' || image == '') {
            alert('Please fill in all fields');
        } else {
            document.getElementById('create-product').submit();
        }
    }
</script>

<body>
    <div class="parent">
        <div class="content">
            <div class="back-to-list">
                <a href="{{ route('web_product_get_all_products') }}"> Back to List products</a>
            </div>
            <div class="add-new-product">
                <form id="create-product" action="{{ route('web_product_create') }}" method="POST"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <h2>Add new product</h2>
                    <input id="name" type="text" name="name" placeholder="Name"
                        @php if (old('name')) {
                            echo 'value="' . old('name') . '"';
                        } @endphp>
                    <span style="color: red">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </span>
                    <input id="description" type="text" name="description" placeholder="Description"
                        @php if (old('name')) {
                      echo 'value="' . old('name') . '"';
                  } @endphp>

                    <span style="color: red">
                        @error('description')
                            {{ $message }}
                        @enderror
                    </span>
                    <input id="image" type="file" name="image" placeholder="Image"
                        @php if (old('image')) {
                      echo 'value="' . old('image') . '"';
                  } @endphp>
                    <span style="color: red">
                        @error('image')
                            {{ $message }}
                        @enderror
                    </span>

                    <button type="button" onclick="confirmCreateNewProduct()">Add new product</button>
                </form>
            </div>

            @if ($product != null)
                <table>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                    </tr>
                    <tr>
                        <td><img src="{{ asset($product->image) }}" alt="" width="100px">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                    </tr>
                </table>
            @endif
        </div>
    </div>

</body>

</html>
