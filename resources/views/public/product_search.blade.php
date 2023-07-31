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
                        <a href="">
                            Tìm kiếm
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="product__container">
        <div class="container">

            @if ($products->count() > 0)
                <div class="product__list">
                    @foreach ($products as $product)
                        <div class="product__item">
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
                        </div>
                    @endforeach

                </div>
            @else
                <div class="text-center">
                    <p>Không tìm thấy sản phẩm nào</p>
                </div>
            @endif
        </div>
    </div>
@endsection
