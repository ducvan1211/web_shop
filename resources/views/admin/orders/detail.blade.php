@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Khách hàng</h5>
            </div>
            <div class="card-body ">
                <div class="font-weight-bold pb-3">
                    Thông tin khách hàng
                </div>
                <table class="table table-striped table-checkall">
                    <tbody>
                        <tr>
                            <td style="width:50%">Mã đơn hàng:</td>
                            <td clas>{{ $order->order_code }}</td>
                        </tr>
                        <tr>
                            <td>Tên khách hàng:</td>
                            <td>{{ $order->customer_name }}</td>
                        </tr>
                        <tr>
                            <td>Số điện thoại:</td>
                            <td>{{ $order->customer_phone }}</td>
                        </tr>
                        <tr>
                            <td>Địa chỉ Email:</td>
                            <td>{{ $order->customer_email }}</td>
                        </tr>
                        <tr>
                            <td>Địa chỉ giao hàng:</td>
                            <td>{{ $order->customer_address }}</td>
                        </tr>
                        <tr>
                            <td>Thời gian đạt hàng:</td>
                            <td>{{ $order->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Ghi chú:</td>
                            <td>{{ $order->customer_note }}</td>
                        </tr>
                        <tr>
                            <td>Phương thức thanh toán:</td>
                            <td>{{ $order->method_payment === 'payment-home' ? 'Thanh toán tại nhà' : 'Thanh toán online' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Tình trạng đơn hàng:</td>
                            <td>
                                <div style="width: 50%">
                                    <form class="d-flex" action="{{ route('admin.order.update', $order->id) }}"
                                        method="POST">
                                        @csrf
                                        <select name="order_status" id="order_status" class="form-control mr-3"
                                            data-id="{{ $order->id }}">
                                            <option {{ $order->order_status === 1 ? 'selected' : '' }} value="1">Đang
                                                xử
                                                lí
                                            </option>
                                            <option {{ $order->order_status === 2 ? 'selected' : '' }} value="2">Đang
                                                vận
                                                chuyển</option>
                                            <option {{ $order->order_status === 3 ? 'selected' : '' }} value="3">Giao
                                                hàng
                                                thành công</option>
                                            <option {{ $order->order_status === 4 ? 'selected' : '' }} value="4">Đơn
                                                hàng
                                                hủy
                                            </option>
                                        </select>
                                        <button class="btn btn-primary" style="width: 150px">Cập nhật</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    <ul class="listPage">

                    </ul>
                </div>
            </div>
        </div>

    </div>
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Đơn hàng</h5>
            </div>
            <div class="card-body ">
                <div class="font-weight-bold pb-3">
                    Thông tin đơn hàng
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col" class="text-center">Màu</th>
                            <th scope="col" class="text-center">Số lượng</th>
                            <th scope="col" class="text-center">Giá</th>
                            <th scope="col" class="text-center">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @if ($products->count() > 0)
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($products as $product)
                                @php
                                    $i++;
                                @endphp
                                <tr class="item">
                                    <td>{{ $i }}</td>
                                    <td><img style="width: 80px;height:80px;object-fit:contain"
                                            src="{{ asset($product->product_img) }}" alt=""></td>
                                    <td>
                                        {{ $product->product_name }}
                                    </td>
                                    <td class="text-center">
                                        {{ $product->product_color }}
                                    </td>
                                    <td class="text-center">
                                        {{ $product->product_qty }}
                                    </td>
                                    <td class="text-center">
                                        {{ number_format($product->product_price, 0, '', '.') }}đ
                                    </td>
                                    <td class="text-center">
                                        {{ number_format($product->product_price * $product->product_qty, 0, '', '.') }}đ
                                    </td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="10">Không tìm thấy bản ghi nào</td>
                            </tr>
                        @endif

                    </tbody>

                </table>
                <div class="text-right order__total">
                    Tổng: {{ number_format($order->order_total, 0, '', '.') }}đ
                </div>
                <div class="d-flex justify-content-center">
                    <ul class="listPage">

                    </ul>
                </div>
            </div>
        </div>

    </div>
    <style>
        .order__total {
            font-weight: bold;
            font-size: 18px;
            text-transform: uppercase;
            padding-top: 10px;
            padding-right: 20px
        }
    </style>
@endsection
