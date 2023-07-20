<style>
    .menu {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        color: #000;
        font-size: 18px;
        padding: 12px;
        font-weight: bold;
        background: #e0c4c4;
    }

    .menu-item {
        padding: 10px;
        margin-left: 20px;
        border-radius: 5px;
    }

    .menu-item a {
        width: 100%;
        height: 100%;
        color: #000;
        text-decoration: none;
    }

    .menu-item:hover {
        background-color: #b26060;
    }
</style>
<header>
    <div class="menu">
        <div class="menu-item">
            <a href="{{ route('web_product_get_all_products') }}">Product List</a>
        </div>
        <div class="menu-item">
            <a href="{{ route('get_all_user') }}">User List</a>
        </div>
        <div class="menu-item">
            <a href="{{ route('get_authorization_home_page') }}">Role - Permission</a>
        </div>
        <div class="menu-item">
            <a href="{{ route('get_user_logout_page') }}">Logout</a>
        </div>


    </div>
</header>
