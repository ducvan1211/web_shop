@extends('layouts.web_public')
@section('content')
    <div class="brand">
        <div class="container">
            <div class="brand__list">
                @foreach ($brands as $brand)
                    <a href="{{ request()->fullUrlWithQuery(['brand' => $brand->slug]) }}"
                        class="brand__item {{ request()->input('brand') === $brand->slug ? 'active' : '' }}">
                        <img src="{{ asset($brand->img) }}" alt="">
                    </a>
                @endforeach
            </div>
        </div>
    </div>
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
                    @if ($cat['cat_parent'])
                        <li class="breadcrumb-item " aria-current="page">
                            <a href="{{ route('product.category', $cat['cat_parent']->slug) }}">
                                {{ $cat['cat_parent']->title }}
                            </a>
                        </li>
                    @endif
                    <li class="breadcrumb-item " aria-current="page">
                        <a href="{{ route('product.category', $cat->slug) }}">
                            {{ $cat->title }}
                        </a>
                    </li>
                    @if ($brand_filter)
                        <li class="breadcrumb-item " aria-current="page">
                            <a href="">
                                {{ $cat->title . ' ' . $brand_filter->b_title }}
                            </a>
                        </li>
                    @endif
                </ol>
            </nav>
        </div>
    </div>
    <div class="product__container">
        <div class="container">
            @if (!$brand_filter)
                <div id="title">
                    <p>{{ $cat->title }}
                    </p>
                </div>
            @endif
            <div class="product__soft">

                <select name="arrange" id="product__filter" class="form-control">
                    <option value="{{ route('product.category', $cat->slug) }}">Giá</option>
                    <option {{ request()->input('filter') === 'duoi1tr' ? 'selected' : '' }}
                        value="{{ request()->fullUrlWithQuery(['filter' => 'duoi1tr']) }}">Dưới 1 triệu</option>
                    <option {{ request()->input('filter') === 'tu1den5tr' ? 'selected' : '' }}
                        value="{{ request()->fullUrlWithQuery(['filter' => 'tu1den5tr']) }}">Từ 1 đến 5 triệu</option>
                    <option {{ request()->input('filter') === 'tu5den10tr' ? 'selected' : '' }}
                        value="{{ request()->fullUrlWithQuery(['filter' => 'tu5den10tr']) }}">Từ 5 đến 10 triệu
                    </option>
                    <option {{ request()->input('filter') === 'tu10den20tr' ? 'selected' : '' }}
                        value="{{ request()->fullUrlWithQuery(['filter' => 'tu10den20tr']) }}">Từ 10 dến 20 triệu
                    </option>
                    <option {{ request()->input('filter') === 'tren20tr' ? 'selected' : '' }}
                        value="{{ request()->fullUrlWithQuery(['filter' => 'tren20tr']) }}">Trên 20 triệu</option>
                </select>

                <select name="arrange" id="product__arrange" class="form-control">
                    <option value="{{ route('product.category', $cat->slug) }}">Sắp xếp</option>
                    <option {{ request()->input('soft') === 'asc' ? 'selected' : '' }}
                        value="{{ request()->fullUrlWithQuery(['soft' => 'asc']) }}">Từ A - Z</option>
                    <option {{ request()->input('soft') === 'desc' ? 'selected' : '' }}
                        value="{{ request()->fullUrlWithQuery(['soft' => 'desc']) }}">Từ Z - A</option>
                    <option {{ request()->input('soft') === 'tangdan' ? 'selected' : '' }}
                        value="{{ request()->fullUrlWithQuery(['soft' => 'tangdan']) }}">Giá tăng dần</option>
                    <option {{ request()->input('soft') === 'giamdan' ? 'selected' : '' }}
                        value="{{ request()->fullUrlWithQuery(['soft' => 'giamdan']) }}">Giá giảm dần</option>
                </select>
            </div>
            <div class="product__list">
                @if ($products->count() > 0)
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
                @else
                    <div class="text-center">
                        <p class="text-center">
                            Cửa hàng không có sản phẩm nào phù hợp
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
