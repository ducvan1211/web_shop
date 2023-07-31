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
                        Danh mục sản phẩm
                    </div>
                    <div class="card-body">
                        <form action="{{ route('cat_product.store') }}" method="POST">
                            @method('POST')
                            @csrf
                            <div class="form-group">
                                <label for="title">Tên danh mục</label>
                                <input class="form-control" type="text" name="title" id="title"
                                    value="{{ old('title') }}">
                                @error('title')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="icon">Icon</label>
                                <input class="form-control" type="text" name="icon" id="icon"
                                    value="{{ old('icon') }}">
                            </div>
                            <div class="form-group">
                                <label for="">Danh mục cha</label>
                                <select name="parent_id" class="form-control" id="">
                                    <option value="0">Chọn danh mục</option>
                                    @foreach ($cats_public as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
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
                                <div class="form-group col-6">
                                    <label for="">Nổi bật</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cat_feature" id="cat1"
                                            value="1">
                                        <label class="form-check-label" for="cat1">
                                            Có
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cat_feature" id="cat2"
                                            value="0" checked>
                                        <label class="form-check-label" for="cat2">
                                            Không
                                        </label>
                                    </div>
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
                                    <th scope="col">Icon</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Nổi bật</th>
                                    <th scope="col">Quản lý</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($cats as $cat)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr class="item">
                                        <th scope="row">{{ $i }}</th>
                                        <td>@php
                                            echo str_repeat('--', $cat->level);
                                        @endphp {{ $cat->title }}</td>
                                        <td>{!! $cat->icon !!}</td>
                                        <td>{{ $cat->slug }}</td>
                                        <td>
                                            @if ($cat->status === '1')
                                                <span class="badge badge-success">Công khai</span>
                                            @else
                                                <span class="badge badge-danger">Chờ duyệt</span>
                                            @endif
                                        </td>
                                        <td>{{ $cat->cat_feature === '1' ? 'Nổi bật' : 'Không' }}</td>
                                        <td class="d-flex">
                                            @canany(['product.add', 'product.edit', 'product.delete'])
                                                <form class="mr-2" action="{{ route('cat_product.destroy', $cat->id) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button onclick="return confirm('Bạn có chắc chắn xóa bản ghi này ?')"
                                                        class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            @endcanany

                                            @canany(['product.add', 'product.edit', 'product.delete'])
                                                <button type="button" class="btn btn-success btn-sm edit_cat_product"
                                                    id="{{ $cat->id }}" data-toggle="modal"
                                                    data-target="#exampleModal">
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

                        {{-- {{ $cats->links() }} --}}
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
                <div class="modal-body" id="modal_update_cat_product">
                    <form id="formUpdateCat">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
