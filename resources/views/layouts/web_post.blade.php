<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BOOSTRAP CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Open+Sans:wght@300;400;500;600;700;800&family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,300;1,400&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100&family=Work+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- ICON -->
    <!-- SLICK CAROUSEL -->
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('./css/main.css') }}">
    <title>Document</title>
</head>

<body>
    <header class="header__post">
        <div class="container">
            <div class="header__top">
                <div>
                    <a href="{{ route('tin-tuc') }}" class="header__logo">
                        <img src="{{ asset('images/logo.png') }}" alt="">
                        <p>Trang tin nhanh</p>
                    </a>
                </div>
            </div>
            <div class="header__nav">
                <ul class="nav__menu">
                    @foreach ($cat_posts as $cat)
                        @if ($cat->parent_id === 0)
                            <li>
                                <a href="{{ route('post.category', $cat->slug) }}">{{ $cat->title }}</a>
                                @if ($cat['has_child'])
                                    <ul class="sub_menu">
                                        @foreach ($cat_posts as $post_child)
                                            @if ($post_child->parent_id === $cat->id)
                                                <li>
                                                    <a
                                                        href="{{ route('post.category', $post_child->slug) }}">{{ $post_child->title }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif

                            </li>
                        @endif
                    @endforeach
                    <li>
                        <a href="{{ route('home') }}">Về Ismart Mobile</a>
                    </li>
                </ul>
                <form class="header__form" action="{{ route('post.search') }}" method="GET">
                    <input type="text" name="s" placeholder="Tìm kiếm..." value="{{ request()->input('s') }}">
                    <button>
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>
    @yield('content')

    <footer>
        <div class="container">
            <div class="footer__content">
                <div class="footer__item">
                    <div class="footer__title">
                        <h3>Tổng đài hỗ trợ miễn phí</h3>
                    </div>
                    <ul class="footer__body">
                        <li>Gọi mua hàng <strong>1800.2097 </strong> (7h30 - 22h00)</li>
                        <li>Gọi khiếu nại <strong>1800.2097 </strong> (7h30 - 22h00)</li>
                        <li>Gọi bảo hành <strong>1800.2097 </strong> (7h30 - 22h00)</li>
                    </ul>
                </div>
                <div class="footer__item">
                    <div class="footer__title">
                        <h3>Thông tin cửa hàng</h3>
                    </div>
                    <ul class="footer__body">
                        <li>
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>106 - Trần Bình - Cầu Giấy - Hà Nội</span>
                        </li>
                        <li>
                            <i class="bi bi-telephone-fill"></i>
                            <span>0987.654.321 - 0989.989.989</span>
                        </li>
                        <li>
                            <i class="bi bi-envelope-fill"></i>
                            <span>vshop@gmail.com</span>
                        </li>
                    </ul>
                </div>
                <div class="footer__item">
                    <div class="footer__title">
                        <h3>Chính sách mua hàng</h3>
                    </div>
                    <ul class="footer__body">
                        <li>
                            <a href="">Quy định - chính sách</a>
                        </li>
                        <li>
                            <a href="">Chính sách bảo hành - đổi trả</a>
                        </li>
                        <li>
                            <a href="">Chính sách hội viện</a>
                        </li>
                        <li>
                            <a href="">Giao hàng - lắp đặt</a>

                        </li>
                    </ul>
                </div>
                <div class="footer__item">
                    <div class="footer__title">
                        <h3>Bảng tin</h3>
                    </div>
                    <ul class="footer__body">
                        <li>
                            Đăng ký với chung tôi để nhận được thông tin ưu đãi sớm nhất
                        </li>
                        <li>
                            <input type="text" placeholder="Nhập email tại đây">
                        </li>
                        <li>
                            <button>Đăng ký</button>

                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="footer__copyright">
            © Bản quyền thuộc về unitop.vn | Php Master
        </div>
    </footer>

    <!-- JQUERY -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- BOOSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CAROUSEL JS -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
