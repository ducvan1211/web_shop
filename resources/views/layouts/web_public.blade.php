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
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
    <title>Document</title>
</head>

<body>
    <div class="header-nav header_nav_fix">
        <div class="container">
            <ul>
                @foreach ($cat_products as $cat)
                    @if ($cat->parent_id === 0)
                        <li>
                            <a href="{{ route('product.category', $cat->slug) }}">
                                {!! $cat->icon !!}
                                <span>{{ $cat->title }}</span>
                            </a>
                            @if ($cat['has_child'])
                                <ul class="sub_menu">
                                    @foreach ($cat_products as $cat_child)
                                        @if ($cat_child->parent_id === $cat->id)
                                            <li>
                                                <a
                                                    href="{{ route('product.category', $cat_child->slug) }}">{{ $cat_child->title }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach
                <li>
                    <a href="{{ route('tin-tuc') }}">
                        <i class="bi bi-newspaper"></i>
                        <span>Tin tức</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <header>
        <div class="header-top">
            <div class="container">
                <ul>
                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li><a href="{{ route('tin-tuc') }}">Tin tức</a></li>
                    @foreach ($pages as $page)
                        <li><a href="{{ route('page', $page->slug) }}">{{ $page->title }}</a></li>
                    @endforeach
                    {{-- <li><a href="">Chính sách</a></li>
                    <li><a href="{{ route('page') }}">Liên hệ</a></li> --}}
                </ul>
            </div>
        </div>
        <div class="header-body">
            <div class="container ">
                <a href="{{ route('home') }}" class="header__logo">
                    <img src="{{ asset('images/logo.png') }}" alt="">
                </a>
                <div class="header__search">
                    <form class="d-flex" action="{{ route('product.search') }}" method="GET">
                        <input type="text" name="s" value="{{ request()->input('s') }}"
                            placeholder="Bạn tìm gì..." class="product__search">
                        <button>
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                    <ul class="result__search">
                        {{-- <li>
                            <a href="" class="card__img">
                                <img src="https://cdn.tgdd.vn/Products/Images/44/231244/macbook-air-m1-2020-gray-600x600.jpg"
                                    alt="">
                            </a>
                            <div class="card__info">
                                <a href="" class="card__name">Điện thoại OPPO Find N2 Flip 5G </a>
                                <p class="card__price">19.990.000₫</p>
                            </div>
                        </li> --}}
                    </ul>
                </div>
                <div class="header__action">
                    <div class="header__advise">
                        <div class="header__advise__icon">
                            <i class="bi bi-headset"></i>
                        </div>
                        <div class="header__advise__phone">
                            <p>Tư vấn</p>
                            <p>0987.654.321</p>
                        </div>
                    </div>
                    <a href="{{ route('cart.index') }}" class="header__cart">
                        <i class="bi bi-cart-check-fill"></i>
                        <p>{{ Cart::count() }}</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="header-nav">
            <div class="container">
                <ul>
                    @foreach ($cat_products as $cat)
                        @if ($cat->parent_id === 0)
                            <li>
                                <a href="{{ route('product.category', $cat->slug) }}">
                                    {!! $cat->icon !!}
                                    <span>{{ $cat->title }}</span>
                                </a>
                                @if ($cat['has_child'])
                                    <ul class="sub_menu">
                                        @foreach ($cat_products as $cat_child)
                                            @if ($cat_child->parent_id === $cat->id)
                                                <li>
                                                    <a
                                                        href="{{ route('product.category', $cat_child->slug) }}">{{ $cat_child->title }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endif
                    @endforeach
                    <li>
                        <a href="{{ route('tin-tuc') }}">
                            <i class="bi bi-newspaper"></i>
                            <span>Tin tức</span>
                        </a>
                    </li>
                </ul>
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
    <div id="back_to_top">
        <a href="#">
            <i class="bi bi-caret-up-fill"></i>
        </a>
    </div>
    <div id="notification__cart">
        <div class="notification__modal">
            <div class="notification__icon">
                <i class="bi bi-check2"></i>
            </div>
            <div class="notification__title">
                <h1>Đã thêm vào giỏ hàng</h1>
            </div>
            <div class="notification__footer">
                <div class="notification__close">
                    Đóng
                </div>
                <a href="{{ route('cart.index') }}" class="notification__buy">
                    Giỏ hàng
                </a>
            </div>
        </div>
    </div>
    <!-- JQUERY -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- BOOSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CAROUSEL JS -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="{{ asset('/js/app.js') }}"></script>
    <script>
        var backToTop = document.getElementById("back_to_top");
        var headerFix = document.querySelector(".header_nav_fix");
        var btnMore = document.querySelector(".btn__more");
        var chooseColor = document.querySelectorAll(".color__item");
        backToTop.style.display = "none";
        headerFix.style.display = "none";
        $(document).ready(function() {
            $(".slider__content").slick();
            $(".product__carousel").slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
            });
        });
        $(".product__img_slider").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            asNavFor: ".product__img_slider_nav",
        });
        $(".product__img_slider_nav").slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: ".product__img_slider",
            dots: false,
            arrows: false,
            centerMode: false,
            focusOnSelect: true,
        });

        window.onscroll = function() {
            // console.log(this.scrollY);
            if (this.scrollY > 300) {
                backToTop.style.display = "block";
                headerFix.style.display = "block";
            } else {
                backToTop.style.display = "none";
                headerFix.style.display = "none";
            }
        };
        // console.log(chooseColor);
        chooseColor.forEach((item) => {
            item.onclick = function() {
                chooseColor.forEach((i) => {
                    if (i.classList.contains("active")) {
                        i.classList.remove("active");
                    }
                });
                item.classList.add("active");
                document.querySelector(".color__err").style.display = "none";
            };
        });
        var is_more = false;

        if (btnMore) {
            btnMore.onclick = function(e) {
                // console.log(e.target);
                if (is_more) {
                    document.querySelector(".product__desc").style.height = "400px";
                    btnMore.innerHTML = "xem thêm";
                    is_more = false;
                } else {
                    document.querySelector(".product__desc").style.height = "auto";
                    btnMore.innerHTML = "Thu gọn";
                    is_more = true;
                }
            };
        }
    </script>
</body>

</html>
