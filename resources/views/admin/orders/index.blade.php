@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('danger'))
                <div class="alert alert-danger" role="alert">
                    {{ session('danger') }}
                </div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách đơn hàng</h5>
                <div class="form-search form-inline">
                    <form class="d-flex" style="margin-left:-10px" action="#">
                        <input type="text" style="margin-right:10px" class="form-control form-search"
                            placeholder="Tìm kiếm" name="s" value="{{ request()->input('s') }}">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ route('admin.order') }}" class="text-primary">Tất cả<span
                            class="text-muted">({{ $count['all'] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'processing']) }}" class="text-primary">Đang xử
                        lí<span class="text-muted">({{ $count['processing'] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'transporting']) }}" class="text-primary">Đang vận
                        chuyển<span class="text-muted">({{ $count['transporting'] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'success']) }}" class="text-primary">Vận chuyển
                        thành công<span class="text-muted">({{ $count['success'] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'cancel']) }}" class="text-primary">Đơn hàng
                        hủy<span class="text-muted">({{ $count['cancel'] }})</span></a>
                </div>
                <form action="{{ route('admin.order.action') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-action form-inline py-3">
                                <select class="form-control mr-1" id="" name="action">
                                    <option>Chọn</option>
                                    @foreach ($actions as $key => $action)
                                        <option value="{{ $key }}">{{ $action }}</option>
                                    @endforeach
                                </select>
                                <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                            </div>
                        </div>

                    </div>

                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input name="checkall" type="checkbox">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Mã đơn hàng</th>
                                <th class="text-center" scope="col">Tên khách hàng</th>
                                <th class="text-center" scope="col">Số lượng SP</th>
                                <th class="text-center" scope="col">Tổng tiền</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Ghi chú</th>
                                <th class="text-center" scope="col">Chi tiết</th>
                                @can('order.delete')
                                    <th scope="col">Tác vụ</th>
                                @endcan
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
                                        <td>
                                            <input type="checkbox" name="checks[{{ $order->id }}]">
                                        </td>
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
                                        <td>
                                            {{ $order->customer_note }}
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route('admin.order.detail', $order->id) }}"><i
                                                    class="bi bi-three-dots"></i></a>
                                        </td>
                                        <td class="">
                                            @can('order.delete')
                                                <div class="d-flex">
                                                    <a href="{{ route('admin.order.delete', $order->id) }}"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Bạn có chắc chắn xóa bản ghi này không ?')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                            @endcan
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
                </form>
                <div class="d-flex justify-content-center">
                    <ul class="listPage">

                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- <tr class="item">
    <td>
        <input type="checkbox" name="checks[{{ $order->id }}]">
    </td>
    <td>{{ $i }}</td>
    <td>{{ $order->order_code }}</td>
    <td>{{ $order->customer_name }}</td>
    <td>{{ $order->customer_phone }}</td>
    <td>{{ $order->customer_email }}</td>
    <td>{{ $order->customer_address }}</td>
    <td>
        @if ($order->order_status === 1)
            <span class="badge badge-warning">Đang xử lí</span>
        @else
            @if ($order->order_status === 2)
                <span class="badge badge-primary">Đang vận chuyển</span>
            @else
                @if ($order->order_status === 3)
                    <span class="badge badge-success">Vận chuyển thành công</span>
                @else
                    @if ($order->order_status === 4)
                        <span class="badge badge-danger">Đơn hàng hủy</span>
                    @else
    </td>
   
</tr> --}}
