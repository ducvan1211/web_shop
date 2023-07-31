@extends('layouts.web_public')
@section('content')
    <div class="breadcrumb__container">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <i class="bi bi-house-door-fill"></i>
                            Home
                        </a>
                    </li>
                    <li class="breadcrumb-item " aria-current="page">
                        <a href="#">
                            Giỏ hàng
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="cart__con">
        <div class="container text-center">
            @if (Cart::count() > 0)
                <table>
                    <thead>
                        <tr>
                            <td>STT</td>
                            <td>Ảnh sản phẩm</td>
                            <td>Tên sản phẩm</td>
                            <td>Màu sản phẩm</td>
                            <td>Giá sản phẩm</td>
                            <td>Số lượng</td>
                            <td>Thành tiền</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $t = 0;
                        @endphp
                        @foreach (Cart::content() as $row)
                            @php
                                $t++;
                            @endphp
                            <tr>
                                <td>{{ $t }}</td>
                                <td>
                                    <img style="width: 60px; height: 60px;object-fit: contain;"
                                        src="{{ asset($row->options->img) }}" alt="">
                                </td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->options->color }}</td>
                                <td> {{ number_format($row->price, 0, '', '.') }} ₫</td>
                                <td>
                                    <div class="product_qty">
                                        <button class="decrease" data-id="{{ $row->rowId }}">-</button>
                                        <input class="num_order product_{{ $row->rowId }}" type="text" readonly
                                            value="{{ $row->qty }}">
                                        <button class="increase" data-id="{{ $row->rowId }}">+</button>
                                    </div>

                                </td>
                                <td class="sub_total_{{ $row->rowId }}">{{ number_format($row->total, 0, '', '.') }} ₫
                                </td>
                                <td>
                                    <a href="{{ route('cart.remove', $row->rowId) }}">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <div class="cart__total">
                                    <p>TỔNg GIÁ: <span class="cart__total-span">{{ Cart::total() }}Đ</span></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <div class="cart__action">
                                    <a href="{{ route('cart.pay') }}">THANH TOÁN</a>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <div class="cart__more text-start">
                    <p> Nhấn vào thanh toán để hoàn tất mua hàng.</p>
                    <a href="{{ route('home') }}">Mua tiếp</a>
                    <a href="{{ route('cart.destroy') }}">Xóa giỏ hàng</a>

                </div>
            @else
                <img src="{{ asset('images/empty-cart.png') }}" alt="">
            @endif


        </div>
    </div>
@endsection
