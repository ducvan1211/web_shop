@extends('layouts.admin')
@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col">
                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($count['success'], 0, '', '.') }}</h5>
                        <p class="card-text">Đơn hàng giao dịch thành công</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐANG XỬ LÝ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($count['processing'], 0, '', '.') }}</h5>
                        <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐANG VẬN CHUYỂN</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($count['transporting'], 0, '', '.') }}</h5>
                        <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
                    <div class="card-header">DOANH SỐ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($total_sales, 0, '', '.') }}</h5>
                        <p class="card-text">Doanh số hệ thống</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG HỦY</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($count['cancel'], 0, '', '.') }}</h5>
                        <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end analytic  -->
        <div class="card">
            <div class="card-header font-weight-bold">
                ĐƠN HÀNG MỚI
            </div>
            <div class="card-body">
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>

                            <th scope="col">#</th>
                            <th scope="col">Mã đơn hàng</th>
                            <th class="text-center" scope="col">Tên khách hàng</th>
                            <th class="text-center" scope="col">Số lượng SP</th>
                            <th class="text-center" scope="col">Tổng tiền</th>
                            <th scope="col">Trạng thái</th>
                            <th class="text-center" scope="col">Thời gian</th>
                            <th class="text-center" scope="col">Chi tiết</th>

                        </tr>
                    </thead>
                    <tbody class="list">
                        @if ($orders->count() > 0)
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($orders as $order)
                                @php
                                    $i++;
                                @endphp
                                <tr class="item">
                                    <td>{{ $i }}</td>
                                    <td>{{ $order->order_code }}</td>
                                    <td class="text-center">
                                        <p>{{ $order->customer_name }}</p>
                                        <p>{{ $order->customer_phone }}</p>
                                    </td>
                                    <td class="text-center">
                                        {{ $order->qty }}
                                    </td>
                                    <td class="text-center">
                                        {{ number_format($order->order_total, 0, '', '.') }}đ
                                    </td>
                                    <td>
                                        @if ($order->order_status === 1)
                                            <span class="badge badge-warning">Đang xử lí</span>
                                        @elseif ($order->order_status === 2)
                                            <span class="badge badge-primary">Đang vận chuyển</span>
                                        @elseif($order->order_status === 3)
                                            <span class="badge badge-success">Vận chuyển thành công</span>
                                        @else
                                            <span class="badge badge-danger">Đơn hàng hủy</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $order->created_at }}
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('admin.order.detail', $order->id) }}"><i
                                                class="bi bi-three-dots"></i></a>
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
                <div class="d-flex justify-content-center">
                    <ul class="listPage">

                    </ul>
                </div>
            </div>
        </div>

    </div>
@endsection
