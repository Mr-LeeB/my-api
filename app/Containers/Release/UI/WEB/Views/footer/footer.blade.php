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
        color: #000000;
        font-size: 16px;
        transition: all 0.3s ease-in-out;
    }

    .footer-social ul li a:hover {
        background-color: #333;
        color: #000000;
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

    @media (max-width: 767px) {
        .footer-menu ul li {
            display: block;
            margin-bottom: 10px;
        }

        .footer-menu ul li:last-child {
            margin-bottom: 0;
        }

        .footer-social {
            text-align: center;
        }

        .footer-social ul li {
            display: block;
            margin-bottom: 10px;
        }

        .footer-social ul li:last-child {
            margin-bottom: 0;
        }
    }

    @media (max-width: 575px) {
        .footer-logo {
            margin-bottom: 20px;
        }
    }

    @media (max-width: 400px) {
        .footer-text {
            font-size: 12px;
        }
    }

    @media (max-width: 300px) {
        .footer-menu ul li {
            margin-right: 10px;
        }

        .footer-social ul li {
            margin-left: 10px;
        }
    }

    @media (max-width: 250px) {
        .footer-menu ul li {
            margin-right: 5px;
        }

        .footer-social ul li {
            margin-left: 5px;
        }
    }

    @media (max-width: 200px) {
        .footer-menu ul li {
            margin-right: 0;
        }

        .footer-social ul li {
            margin-left: 0;
        }
    }

    @media (max-width: 767px) {
        .footer-menu ul li {
            display: block;
            margin-bottom: 10px;
        }

        .footer-menu ul li:last-child {
            margin-bottom: 0;
        }

        .footer-social {
            text-align: center;
        }

        .footer-social ul li {
            display: block;
            margin-bottom: 10px;
        }

        .footer-social ul li:last-child {
            margin-bottom: 0;
        }
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
                    <a href=""><img src="{{ asset('img/logo.png') }}" alt="logo"></a>
                </div>
                <div class="footer-text">
                    <p>© 2021 All Rights Reserved. Design by <a
                            href="https://www.facebook.com/"><span>Mr-LeeB</span></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
