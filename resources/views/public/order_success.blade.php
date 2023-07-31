@extends('layouts.web_public')
@section('content')
    <div class="order__container">
        <div class="container">
            <div class="order__title text-center">
                <h1>Bạn đã đặt hàng thành công</h1>
                <p>Nhân viên chăm sóc sẽ liên hệ với bạn sớm nhất để xác nhận đơn hàng</p>
            </div>
            <div class="order__code">
                <p>Mã đơn hàng: {{ $order->order_code }}</p>
            </div>
            <table class="table">
                <tbody>
                    <tr>
                        <td class="w-50">Tên khách hàng:</td>
                        <td>{{ $order->customer_name }}</td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td>{{ $order->customer_email }}</td>
                    </tr>
                    <tr>
                        <td>Số điện thoại:</td>
                        <td>{{ $order->customer_phone }}</td>
                    </tr>
                    <tr>
                        <td>Địa chỉ:</td>
                        <td>{{ $order->customer_address }}</td>
                    </tr>
                    <tr>
                        <td>Ghi chú:</td>
                        <td>{{ $order->customer_note }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table">
                <thead>
                    <tr>
                        <td>#</td>
                        <td class="text-center">ẢNH</td>
                        <td>TÊN SẢN PHẨM</td>
                        <td class="text-center">GIÁ</td>
                        <td class="text-center">SỐ LƯỢNG</td>
                        <td class="text-center">MÀU</td>
                        <td class="text-center">THÀNH TIỀN</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($products as $product)
                        @php
                            $i++;
                        @endphp
                        <tr>
                            <td>{{ $i }}</td>
                            <td class="text-center"><img style="width: 80px;height:80px;object-fit:contain"
                                    src="{{ asset($product->product_img) }}" alt=""></td>
                            </td>
                            <td>
                                {{ $product->product_name }}
                            </td>
                            <td class="text-center">
                                {{ number_format($product->product_price, 0, '', '.') }}đ
                            </td>

                            <td class="text-center">
                                {{ $product->product_qty }}
                            </td>
                            <td class="text-center">
                                {{ $product->product_color }}
                            </td>
                            <td class="text-center">
                                {{ number_format($product->product_price * $product->product_qty, 0, '', '.') }}đ
                            </td>
                        </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <td class=text-end colspan="7">Tổng tiền: {{ number_format($order->order_total, 0, '', '.') }}đ
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

@endsection
