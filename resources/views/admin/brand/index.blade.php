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
                        Thương hiệu sản phẩm
                    </div>
                    <div class="card-body">
                        <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="form-group">
                                <label for="b_title">Tên thương hiệu</label>
                                <input class="form-control" type="text" name="b_title" id="b_title"
                                    {{ old('b_title') }}>
                                @error('b_title')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="img">Hình ảnh</label>
                                <input type="file" id="img" name="img" class="form-control">
                                @error('img')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div>
                                    <label for="">Thương hiệu thuộc danh mục</label>
                                </div>
                                @foreach ($cats as $cat)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="cat_{{ $cat->id }}"
                                            value="{{ $cat->id }}" name="cats[{{ $cat->id }}]">
                                        <label class="form-check-label"
                                            for="cat_{{ $cat->id }}">{{ $cat->title }}</label>
                                    </div>
                                @endforeach
                                @error('cats')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group ">
                                <label for="">Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status1"
                                        value="0">
                                    <label class="form-check-label" for="status1">
                                        Chờ duyệt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="exampleRadios2"
                                        value="1" checked>
                                    <label class="form-check-label" for="exampleRadios2">
                                        Công khai
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
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
                                    <th scope="col">Tên danh mục</th>
                                    <th scope="col">Hình ảnh</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Quản lý</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($brands as $brand)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr class="item">
                                        <th scope="row">{{ $i }}</th>
                                        <td>{{ $brand->b_title }}</td>
                                        <td>
                                            <img style="width: 80px;height:40px;object-fit:contain;"
                                                src="{{ asset($brand->img) }}" alt="">
                                        </td>
                                        <td>{{ $brand->slug }}</td>
                                        <td>
                                            @if ($brand->status === '1')
                                                <span class="badge badge-success">Công khai</span>
                                            @else
                                                <span class="badge badge-danger">Chờ duyệt</span>
                                            @endif
                                        </td>
                                        <td class="d-flex">
                                            @canany(['product.edit', 'product.add', 'product.delete'])
                                                <form class="mr-2" action="{{ route('brand.destroy', $brand->id) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button onclick="return confirm('Bạn có chắc chắn xóa bản ghi này ?')"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-success btn-sm edit_brand"
                                                    id="{{ $brand->id }}" data-toggle="modal" data-target="#exampleModal">
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
                    <h5 class="modal-title" id="exampleModalLabel">Cập nhật danh mục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_update_brand">
                    <form id="formUpdate">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
