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
                        Màu sắc sản phẩm
                    </div>
                    <div class="card-body">
                        <form action="{{ route('color.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title">Màu sắc</label>
                                <input class="form-control" type="text" name="title" id="title"
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
                                    <th scope="col">Màu sắc</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($colors as $color)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr class="item">
                                        <th scope="row">{{ $i }}</th>
                                        <td>{{ $color->title }}</td>
                                        <td>
                                            @if ($color->status === '1')
                                                <span class="badge badge-success">Công khai</span>
                                            @else
                                                <span class="badge badge-danger">Chờ duyệt</span>
                                            @endif
                                        </td>
                                        <td class="d-flex">
                                            @canany(['product.add', 'product.edit', 'product.delete'])
                                                <form class="mr-2" action="{{ route('color.destroy', $color->id) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button onclick="return confirm('Bạn có chắc chắn xóa bản ghi này ?')"
                                                        class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                                <button type="button" class="btn btn-success btn-sm edit_color"
                                                    id="{{ $color->id }}" data-toggle="modal" data-target="#exampleModal">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                            @endcanany
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            <ul class="listPage">

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cập nhật màu sắc</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_update_color">
                    <form id="formUpdateColor">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
