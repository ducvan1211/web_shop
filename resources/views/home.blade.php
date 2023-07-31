@extends('layouts.web_public')
@section('content')
    <div class="slider">
        <div class="container">
            <div class="slider__content">
                @foreach ($sliders as $slider)
                    <div>
                        <a href="{{ $slider->link }}">
                            <img src="{{ asset($slider->img) }}" alt="{{ $slider->title }}">
                        </a>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <div class="support">
        <div class="container">
            <div class="support__list">
                <div class="support__item">
                    <div class="support_img">
                        <img src="{{ asset('images/icon-1.png') }}" alt="">
                    </div>
                    <h3>Miễn phí vận chuyển</h3>
                    <p>Tới tận tay khách hàng</p>
                </div>
                <div class="support__item">
                    <div class="support_img">
                        <img src="{{ asset('images/icon-2.png') }}" alt="">
                    </div>
                    <h3>Tư vấn 24/7</h3>
                    <p>1900.9999</p>
                </div>
                <div class="support__item">
                    <div class="support_img">
                        <img src="{{ asset('images/icon-3.png') }}" alt="">
                    </div>
                    <h3>Tiết kiệm hơn</h3>
                    <p>Với nhiều ưu đãi cực lớn</p>
                </div>
                <div class="support__item">
                    <div class="support_img">
                        <img src="{{ asset('images/icon-4.png') }}" alt="">
                    </div>
                    <h3>Thanh toán nhanh</h3>
                    <p>Hỗ trợ nhiều hình thức</p>
                </div>
                <div class="support__item">
                    <div class="support_img">
                        <img src="{{ asset('images/icon-5.png') }}" alt="">
                    </div>
                    <h3>Đặt hàng online</h3>
                    <p>Thao tác đơn giản</p>
                </div>
            </div>
        </div>
    </div>
    @if ($banners->count() >= 1)
        <div class="banner">
            <div class="container">
                <a href="{{ $banners[0]->link }}">
                    <img style="width: 100%; object-fit: cover;" src="{{ asset($banners[0]->img) }}" alt="">
                </a>
            </div>
        </div>
    @endif
    <div class="product__like">
        <div class="container">
            <div id="title">
                <p>Có thể bạn sẽ thích</p>
            </div>
            <div class="product__carousel">
                @foreach ($new_products as $product)
                    <div class="product__card">
                        <div class="card__img">
                            <a href="{{ route('product.detail', $product->slug) }}">
                                <img src="{{ asset($product->img) }}" alt="">
                            </a>
                        </div>
                        <div class="card__info">
                            <a href="{{ route('product.detail', $product->slug) }}"
                                class="product__title">{{ $product->title }}</a>
                            <p class="product__price new">{{ number_format($product->price, 0, '', '.') }} đ</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @if ($mobiles->count() > 0)
        <div class="product__container">
            <div class="container">
                <div id="title">
                    <p>Điện thoại nổi bật</p>
                </div>
                <div class="product__list">
                    @foreach ($mobiles as $mobile)
                        <div class="product__item">
                            <div class="product__card">
                                <div class="card__img">
                                    <a href="{{ route('product.detail', $mobile->slug) }}">
                                        <img src="{{ asset($mobile->img) }}" alt="">
                                    </a>
                                </div>
                                <div class="card__info">
                                    <a href="{{ route('product.detail', $mobile->slug) }}"
                                        class="product__title">{{ $mobile->title }}</a>
                                    <p class="product__price new">{{ number_format($mobile->price, 0, '', '.') }} đ</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    @if ($banners->count() >= 2)
        <div class="banner">
            <div class="container">
                <a href="{{ $banners[1]->link }}">
                    <img style="width: 100%; object-fit: cover;" src="{{ asset($banners[1]->img) }}" alt="">
                </a>
            </div>
        </div>
    @endif
    @if ($laptops->count() > 0)
        <div class="product__container">
            <div class="container">
                <div id="title">
                    <p>Laptop nổi bật</p>
                </div>
                <div class="product__list">
                    @foreach ($laptops as $laptop)
                        <div class="product__item">
                            <div class="product__card">
                                <div class="card__img">
                                    <a href="{{ route('product.detail', $laptop->slug) }}">
                                        <img src="{{ asset($laptop->img) }}" alt="">
                                    </a>
                                </div>
                                <div class="card__info">
                                    <a href="{{ route('product.detail', $laptop->slug) }}"
                                        class="product__title">{{ $laptop->title }}</a>
                                    <p class="product__price new">{{ number_format($laptop->price, 0, '', '.') }} đ</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    @if ($banners->count() === 3)
        <div class="banner">
            <div class="container">
                <a href="{{ $banners[2]->link }}">
                    <img style="width: 100%; object-fit: cover;" src="{{ asset($banners[2]->img) }}" alt="">
                </a>
            </div>
        </div>
    @endif
    @if ($watchs->count() > 0)
        <div class="product__like">
            <div class="container">
                <div id="title">
                    <p>Đồng hồ thông minh</p>
                </div>
                <div class="product__carousel">
                    @foreach ($watchs as $watch)
                        <div class="product__card">
                            <div class="card__img">
                                <a href="{{ route('product.detail', $watch->slug) }}">
                                    <img src="{{ asset($watch->img) }}" alt="">
                                </a>
                            </div>
                            <div class="card__info">
                                <a href="{{ route('product.detail', $watch->slug) }}"
                                    class="product__title">{{ $watch->title }}</a>
                                <p class="product__price new">{{ number_format($watch->price, 0, '', '.') }} đ</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    @if ($tvs->count() > 0)
        <div class="product__like">
            <div class="container">
                <div id="title">
                    <p>Smart TV</p>
                </div>
                <div class="product__carousel">
                    @foreach ($tvs as $tv)
                        <div class="product__card">
                            <div class="card__img">
                                <a href="{{ route('product.detail', $tv->slug) }}">
                                    <img src="{{ asset($tv->img) }}" alt="">
                                </a>
                            </div>
                            <div class="card__info">
                                <a href="{{ route('product.detail', $tv->slug) }}"
                                    class="product__title">{{ $tv->title }}</a>
                                <p class="product__price new">{{ number_format($tv->price, 0, '', '.') }} đ</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    @if ($headphones->count() > 0)
        <div class="product__like">
            <div class="container">
                <div id="title">
                    <p>Tai nghe</p>
                </div>
                <div class="product__carousel">
                    @foreach ($headphones as $headphone)
                        <div class="product__card">
                            <div class="card__img">
                                <a href="{{ route('product.detail', $headphone->slug) }}">
                                    <img src="{{ asset($headphone->img) }}" alt="">
                                </a>
                            </div>
                            <div class="card__info">
                                <a href="{{ route('product.detail', $headphone->slug) }}"
                                    class="product__title">{{ $headphone->title }}</a>
                                <p class="product__price new">{{ number_format($headphone->price, 0, '', '.') }} đ</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
