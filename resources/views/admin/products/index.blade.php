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
                <h5 class="m-0 ">Danh sách sản phẩm</h5>
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
                    <a href="{{ route('product.index') }}" class="text-primary">Tất cả<span
                            class="text-muted">({{ $count['all'] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'stocking']) }}" class="text-primary">Còn hàng<span
                            class="text-muted">({{ $count['stocking'] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'out_stock']) }}" class="text-primary">Hết
                        hàng<span class="text-muted">({{ $count['out_stock'] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'public']) }}" class="text-primary">Công khai<span
                            class="text-muted">({{ $count['public'] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="text-primary">Chờ
                        duyệt<span class="text-muted">({{ $count['pending'] }})</span></a>
                </div>
                <form action="{{ route('product.action') }}" method="POST">
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
                        <div class="col-6 text-right d-flex justify-content-end align-items-center">
                            <a href="{{ route('product.create') }}" class="btn btn-primary">Thêm
                                mới</a>
                        </div>
                    </div>

                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input name="checkall" type="checkbox">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Màu</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Hiển thị</th>
                                <th scope="col">Tác vụ</th>
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
                                        <td>
                                            <input type="checkbox" name="checks[{{ $product->id }}]">
                                        </td>
                                        <td>{{ $i }}</td>
                                        <td><img style="width: 80px;height:80px;object-fit:contain"
                                                src="{{ asset($product->img) }}" alt=""></td>
                                        <td><a href="{{ route('product.edit', $product->id) }}">{{ $product->title }}</a>
                                        </td>
                                        <td>{{ number_format($product->price, 0, '', '.') }} vnd</td>
                                        <td>
                                            @foreach ($product->colors as $color)
                                                <span class="badge badge-success">{{ $color->title }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($product->categories as $cat)
                                                <span class="badge badge-warning">{{ $cat->title }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if ($product->is_stocking === '1')
                                                <span class="badge badge-success">Còn hàng</span>
                                            @else
                                                <span class="badge badge-danger">Hết hàng</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($product->status === '1')
                                                <span class="badge badge-success">Công khai</span>
                                            @else
                                                <span class="badge badge-danger">Chờ duyệt</span>
                                            @endif
                                        </td>
                                        <td class="">
                                            <div class="d-flex">
                                                <a href="{{ route('product.edit', $product->id) }}"
                                                    class="btn btn-success btn-sm mr-2" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                @can('product.delete')
                                                    <a href="{{ route('product.delete', $product->id) }}"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Bạn có chắc chắn xóa bản ghi này không ?')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endcan

                                            </div>
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
