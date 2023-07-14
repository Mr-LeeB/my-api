<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Details</title>

    <style>
        html,
        body {
            background-color: #fff;
            color: #000;
            font-family: 'Roboto', sans-serif;
            font-weight: 100;
            height: 100%;
            margin: 0;
        }

        .header {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 0 12px
        }

        .title {
            text-align: center;

        }

        .parent {
            display: flex;
            flex-direction: column;

            width: 100%;
            height: 100%;
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
            color: #cd3737;
        }

        .content {
            display: flex;
            flex-direction: row;
            margin: 20px;
            padding: 20px;
            border-radius: 5px;
            height: 100%;
        }

        .product-detail {
            display: flex;
            align-items: flex-start;
            width: 100%;
            margin-left: 20px;
            padding: 0 20px;
            border-radius: 5px;
        }

        .product-detail .form-detail {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            width: 100%;
            margin-left: 20px;
            padding: 0 20px;
        }

        input {
            width: 100%;
            display: inline-block;
        }

        .descripton textarea {
            margin: 10px 0;
            padding: 5px;
            width: 95vh;
            height: 100%;
            max-height: 50vh;
            border: #000 1px solid;
            resize: vertical;
        }

        .image-product {
            margin-left: 20px;
        }

        img {
            border-radius: 10px;
            border: #411df3 1px solid;
        }

        .descripton .info {
            width: 100%;
        }

        .detail {
            width: 100%;
        }

        .handle {
            display: flex;
            flex-direction: row;
            align-items: center;
            width: 100%;
        }

        #btn-enable-edit-product {
            margin: 10px;
            padding: 5px;
            width: 100px;
            background-color: #411df3;
            color: #fff;
            border: none;
            border-radius: 5px;
        }

        #btn-enable-edit-product:hover {
            background-color: #2cd720;
        }

        #btn-save-product {
            display: none;
            margin: 10px;
            padding: 5px;
            width: 100px;
            background-color: #411df3;
            color: #fff;
            border: none;
            border-radius: 5px;
        }

        #btn-save-product:hover {
            background-color: #2cd720;
        }

        #btn-cancle-edit-product {
            display: none;
            margin: 10px;
            padding: 5px;
            width: 100px;
            background-color: #d21111;
            color: #fff;
            border: none;
            border-radius: 5px;
        }

        #btn-cancle-edit-product:hover {
            background-color: #4e0505;
        }

        #description,
        #id,
        #name {
            display: none;
        }

        #image {
            width: 25%;
        }

        #btn-delete-product {
            margin: 10px;
            padding: 5px;
            width: 100px;
            background-color: #d21111;
            color: #fff;
            border: none;
            border-radius: 5px;
        }

        #btn-delete-product:hover {
            background-color: #4e0505;
        }
    </style>

    <script>
        function enableEdit() {
            document.getElementById("description").style.display = "inline-block";
            document.getElementById("name").style.display = "inline-block";
            document.getElementById("btn-enable-edit-product").style.display = "none";
            document.getElementById("btn-save-product").style.display = "inline-block";
            document.getElementById("btn-cancle-edit-product").style.display = "inline-block";
            document.getElementsByClassName("image")[0].style.display = "inline-block";

            document.getElementsByClassName("info")[0].style.display = "none";
            document.getElementsByClassName("info")[2].style.display = "none";
        }

        function cancleEdit() {
            document.getElementById("description").style.display = "none";
            document.getElementById("name").style.display = "none";
            document.getElementById("btn-enable-edit-product").style.display = "inline-block";
            document.getElementById("btn-save-product").style.display = "none";
            document.getElementById("btn-cancle-edit-product").style.display = "none";
            document.getElementsByClassName("image")[0].style.display = "none";

            document.getElementsByClassName("info")[0].style.display = "inline-block";
            document.getElementsByClassName("info")[2].style.display = "inline-block";


        }

        function confirmSave() {
            var r = confirm("Are you sure to save?");
            if (r == true) {
                document.getElementById("btn-save-product").type = "submit";
            } else {
                document.getElementById("btn-save-product").type = "button";
            }
        }

        function confirmDeleteProduct() {
            var r = confirm("Are you sure to delete?");
            if (r == true) {
                document.getElementById("btn-delete-product").type = "submit";
            } else {
                document.getElementById("btn-delete-product").type = "button";
            }
        }
    </script>
</head>

<body>
    <div class="parent">
        <div class="header">
            <div class="back-to-list">
                <a href="{{ route('web_product_get_all_products') }}">Back to list</a>
            </div>
            <div class="title m-b-md">
                <h1>Product Details</h1>
            </div>
            <div>
                <form id="form-delete-product" action="{{ route('web_product_delete', $product->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type=" button" id="btn-delete-product" onclick="confirmDeleteProduct()">Remove</button>
                </form>
            </div>
        </div>
        <div class="content">
            <span>
                @if (session('message'))
                    {{ session('message') }}
                @endif
            </span>
            <span>
                @if (session('error'))
                    {{ session('error') }}
                @endif
            </span>
            <div class="image-product">
                <img src="{{ $product->image }}" alt="image" width="600px" height="600px">
                <span>
                    @if ($errors->has('image'))
                        {{ $errors->first('image') }}
                    @endif
                </span>
            </div>
            <div class="product-detail">
                <form class="form-detail" action="{{ route('web_product_update', $product->id) }}" method="POST"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="descripton">
                        <h2 class="description-product">Description: </h2>
                        <textarea name="description" id="description">{{ $product->description }}</textarea>
                        <p class="info">{{ $product->description }}</p>
                    </div>
                    <span>
                        @if ($errors->has('description'))
                            {{ $errors->first('description') }}
                        @endif
                    </span>

                    <h2 class="description-product">Details: </h2>
                    <div class="id detail">
                        <p class="id-product" style="display: inline-block">ID: </p>
                        <input type="text" id="id" value="{{ $product->id }}">
                        <p class="info" style="display: inline-block">{{ $product->id }}</p>
                    </div>

                    <div class="name detail">
                        <p class="name-product" style="display: inline-block">Name: </p>
                        <input type="text" name="name" id="name" value="{{ $product->name }}">
                        <p class="info" style="display: inline-block">{{ $product->name }}</p>

                    </div>
                    <span>
                        @if ($errors->has('name'))
                            {{ $errors->first('name') }}
                        @endif
                    </span>


                    <div class="image detail" style="display: none;">
                        <p>Image: </p>
                        <input type="file" name="image" id="image">
                    </div>



                    <div class="handle">
                        <input type="button" id="btn-enable-edit-product" value="Edit" onclick="enableEdit()">
                        <input type="button" id="btn-save-product" value="Save" onclick="confirmSave()">
                        <input type="button" id="btn-cancle-edit-product" value="Cancle" onclick="cancleEdit()">
                    </div>
                </form>

            </div>

        </div>
    </div>
</body>

</html>
