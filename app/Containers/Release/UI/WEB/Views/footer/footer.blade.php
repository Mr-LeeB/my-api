<style>
    .container {
        margin: 0 auto;
        padding: 0 20px;
    }

    footer a {
        color: #000000;
        text-decoration: none;
    }

    .footer-menu ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-menu ul li {
        display: inline-block;
        margin-right: 20px;
    }

    .footer-menu ul li:last-child {
        margin-right: 0;
    }

    .footer-social ul {
        list-style: none;
        padding: 0;
        margin: 0;
        text-align: right;
    }

    .footer-social ul li {
        display: inline-block;
        margin-left: 20px;
    }

    .footer-social ul li:first-child {
        margin-left: 0;
    }

    .footer-social ul li a {
        display: block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        border-radius: 50%;
        background-color: #333;
        color: #ecdada;
        font-size: 16px;
        transition: all 0.3s ease-in-out;
    }

    .footer-social ul li a:hover {
        background-color: #c2b4b4;
        color: #4704ff;
    }

    .footer-social ul li a i {
        line-height: inherit;
        padding-right: 12px;
    }


    .footer-logo {
        text-align: center;
        margin: 30px 0;
    }

    .footer-logo a {
        display: inline-block;
    }

    .footer-logo img {
        width: 100px;
        height: auto;
    }

    .footer-text {
        text-align: center;
    }

    .footer-text p {
        margin: 0;
    }

    .footer-text p span {
        color: #f82249;
    }
</style>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="footer-menu">
                    <ul>
                        <li><a href="">Home</a></li>
                        <li><a href="">About</a></li>
                        <li><a href="">Contact</a></li>
                        <li><a href="">Privacy</a></li>
                        <li><a href="">Terms</a></li>
                    </ul>
                </div>
                <div class="footer-social">
                    <ul>
                        <li><a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://twitter.com/"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="https://www.linkedin.com/"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="https://www.instagram.com/"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="https://www.youtube.com/"><i class="fa fa-youtube"></i></a></li>
                    </ul>
                </div>
                <div class="footer-logo">
                    <a href=""><img src="/img/logo.png" alt="logo"></a>
                    {{-- <a href=""><img src="{{ asset('img/logo.png') }}" alt="logo"></a> --}}
                </div>
                <div class="footer-text">
                    <p>© 2021 All Rights Reserved. Design by <a
                            href=""><span>Mr-LeeB</span></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>