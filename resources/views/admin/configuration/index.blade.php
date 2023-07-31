@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-4">
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
                    <div class="card-header font-weight-bold">
                        Cấu hình loại sản phẩm
                    </div>
                    <div class="card-body">
                        <form action="{{ route('configuration_type.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="t_title">Cấu hình loại sản phẩm</label>
                                <input class="form-control" type="text" name="title" id="t_title"
                                    {{ old('title') }}>
                                @error('title')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="color_add_1"
                                        value="0">
                                    <label class="form-check-label" for="color_add_1">
                                        Chờ duyệt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="color_add_2"
                                        value="1" checked>
                                    <label class="form-check-label" for="color_add_2">
                                        Công khai
                                    </label>
                                </div>
                            </div>
                            <button type="submit" name="btn_add" class="btn btn-primary">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh sách
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Cấu hình loại sản phẩm</th>
                                    <th scope="col">Trạng thái</th>
                                    @canany(['product.add', 'product.edit', 'product.delete'])
                                        <th class="text-center" scope="col">Thao tác</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody class="listType">
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($types as $type)
                                    @php
                                        $i++;
                                    @endphp

                                    <tr class="item">
                                        <th scope="row">{{ $i }}</th>
                                        <td class="t_title_update" id="{{ $type->id }}" style="outline: none"
                                            @canany(['product.add', 'product.edit', 'product.delete'])
                                            contenteditable
                                        @endcanany>
                                            {{ $type->title }}
                                        </td>
                                        <td>
                                            <select class="form-control type_status" data-id="{{ $type->id }}">
                                                <option @if ($is_disable) disabled @endif
                                                    {{ $type->status == '0' ? 'selected' : '' }} value="0">Chờ
                                                    duyệt
                                                </option>
                                                <option @if ($is_disable) disabled @endif
                                                    {{ $type->status == '1' ? 'selected' : '' }} value="1">Công
                                                    khai</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            @canany(['product.add', 'product.edit', 'product.delete'])
                                                <form class="mr-2"
                                                    action="{{ route('configuration_type.destroy', $type->id) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button onclick="return confirm('Bạn có chắc chắn xóa bản ghi này ?')"
                                                        class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            @endcanany
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            <ul class="listPage listPaginationType">

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-4">
                <div class="card">
                    @if (session('status_detail'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status_detail') }}
                        </div>
                    @endif
                    @if (session('danger_detail'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('danger_detail') }}
                        </div>
                    @endif
                    <div class="card-header font-weight-bold">
                        Thuộc tính sản phẩm
                    </div>
                    <div class="card-body">
                        <form action="{{ route('configuration_detail.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="d_title">Tên thuộc tính sản phẩm</label>
                                <input class="form-control" type="text" name="title" id="d_title">
                                @error('title')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="type_id">Thuộc loại cấu hình</label>
                                <select name="type_id" id="type_id" class="form-control">
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="detail_add_1"
                                        value="0">
                                    <label class="form-check-label" for="detail_add_1">
                                        Chờ duyệt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="detail_add_2"
                                        value="1" checked>
                                    <label class="form-check-label" for="detail_add_2">
                                        Công khai
                                    </label>
                                </div>
                            </div>
                            <button type="submit" name="btn_add" class="btn btn-primary">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh sách
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Thuộc tính sản phẩm</th>
                                    <th scope="col">Thuộc cấu hình sản phẩm</th>
                                    <th scope="col">Trạng thái</th>
                                    @canany(['product.add', 'product.edit', 'product.delete'])
                                        <th class="text-center" scope="col">Thao tác</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody class="listDetail">
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($details as $detail)
                                    @php
                                        $i++;
                                    @endphp

                                    <tr class="item">
                                        <th scope="row">{{ $i }}</th>
                                        <td class="d_title_update" id="{{ $detail->id }}" style="outline: none"
                                            @canany(['product.add', 'product.edit', 'product.delete'])
                                            contenteditable
                                        @endcanany>
                                            {{ $detail->title }}
                                        </td>
                                        <td>
                                            <select class="form-control type_id" data-id="{{ $detail->id }}">
                                                @foreach ($types as $type)
                                                    <option @if ($is_disable) disabled @endif
                                                        {{ $type->id === $detail->type_id ? 'selected' : '' }}
                                                        value="{{ $type->id }}">{{ $type->title }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control detail_status" data-id="{{ $detail->id }}">
                                                <option @if ($is_disable) disabled @endif
                                                    {{ $detail->status == '0' ? 'selected' : '' }} value="0">Chờ
                                                    duyệt
                                                </option>
                                                <option @if ($is_disable) disabled @endif
                                                    {{ $detail->status == '1' ? 'selected' : '' }} value="1">Công
                                                    khai</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            @canany(['product.add', 'product.edit', 'product.delete'])
                                                <form class="mr-2"
                                                    action="{{ route('configuration_detail.destroy', $detail->id) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button onclick="return confirm('Bạn có chắc chắn xóa bản ghi này ?')"
                                                        class="btn btn-danger btn-sm"><i
                                                            class="fas fa-trash-alt"></i></button>
                                                </form>
                                            @endcanany


                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            <ul class="listPage listPageDetailConfiguration">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
