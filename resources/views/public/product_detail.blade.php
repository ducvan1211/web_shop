@extends('layouts.web_public')
@section('content')
    <div class="breadcrumb__container">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">
                            <i class="bi bi-house-door-fill"></i>
                            Home
                        </a>
                    </li>
                    <li class="breadcrumb-item " aria-current="page">
                        <a href="{{ route('product.category', $cat->slug) }}">
                            {{ $cat->title }}
                        </a>
                    </li>
                    <li class="breadcrumb-item " aria-current="page">
                        <a href="{{ route('product.detail', $product->slug) }}">
                            {{ $product->title }}
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="product__detail">
        <div class="container">
            <div class="product__deatil__header">
                <h1>{{ $product->title }}</h1>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="product__img_slider">
                        @foreach ($images as $img)
                            <img style="width: 100%" src="{{ asset($img->image) }}" alt="">
                        @endforeach

                    </div>
                    <div class="product__img_slider_nav">
                        @foreach ($images as $img)
                            <div class="product__img_item">
                                <img src="{{ asset($img->image) }}" alt="">
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="col-4">
                    <div class="product__info">
                        <h3 class="product__price">
                            {{ number_format($product->price, 0, '', '.') }} ₫
                        </h3>
                        <div class="freeship">
                            <i class="bi bi-truck"></i>
                            <span>MIỄN PHÍ VẬN CHUYỂN TOÀN QUỐC</span>
                        </div>
                        <div class="product__color">
                            <p>Lựa chọn màu</p>
                            <div class="color__list">
                                @foreach ($product->colors as $color)
                                    <div class="color__item" data-id="{{ $color->id }}">
                                        {{ $color->title }}
                                    </div>
                                @endforeach
                                <div class="span color__err text-form text-danger" style="display: none">
                                    Vui lòng chọn màu sắc sản phẩm
                                </div>
                            </div>
                        </div>
                        @if ($product->config)
                            <div class="product__config">
                                <p>Cấu hình sản phẩm</p>
                                <ul>
                                    @foreach (json_decode($product->config) as $k => $v)
                                        <li>
                                            <strong>{{ $k }}: </strong>
                                            <span>{{ $v }}</span>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        @endif
                        <div class="product__action">
                            <a href="{{ route('cart.pay') }}" class="product__buy" data-id="{{ $product->id }}">
                                Mua ngay
                            </a>
                            <button class="product__add_cart" data-id="{{ $product->id }}">
                                <i class="bi bi-cart-plus-fill"></i>
                                <p>Thêm vào giỏ hàng</p>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="product__content">
                <div class="title">Mô tả sản phẩm</div>
                <div class="product__desc">
                    {!! $product->content !!}
                </div>
                <div class="btn__more">Xem thêm</div>
            </div>
        </div>
    </div>
    <div class="product__like">
        <div class="container">
            <div id="title">
                <p>Sản phẩm tương tự</p>
            </div>
            <div class="product__carousel">
                @foreach ($product_list as $item)
                    <div class="product__card">
                        <div class="card__img">
                            <a href="{{ route('product.detail', $item->slug) }}">
                                <img src="{{ asset($item->img) }}" alt="">
                            </a>
                        </div>
                        <div class="card__info">
                            <a href="{{ route('product.detail', $item->slug) }}"
                                class="product__title">{{ $item->title }}</a>
                            <p class="product__price new">{{ number_format($item->price, 0, '', '.') }} ₫</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
