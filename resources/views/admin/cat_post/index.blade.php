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
                        Thêm danh mục bài viết
                    </div>
                    <div class="card-body">
                        <form action="{{ route('post_cat.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên danh mục</label>
                                <input class="form-control" type="text" name="title" id="name"
                                    value="{{ old('title') }}">
                            </div>
                            <div class="form-group">
                                <label for="parent">Danh mục cha</label>
                                <select class="form-control" id="parent" name="parent_id">
                                    <option value="0">Chọn danh mục</option>
                                    @foreach ($cat_publics as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status_add_0"
                                        value="0">
                                    <label class="form-check-label" for="status_add_0">
                                        Chờ duyệt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status_add_1"
                                        value="1" checked>
                                    <label class="form-check-label" for="status_add_1">
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
                        Danh mục bài viết
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên danh mục</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Handle</th>
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
                                        <td>{{ $cat->slug }}</td>
                                        <td>
                                            @if ($cat->status === '1')
                                                <span class="badge badge-success">Công khai</span>
                                            @else
                                                <span class="badge badge-danger">Chờ duyệt</span>
                                            @endif
                                        </td>
                                        <td class="d-flex">
                                            @can('post.delete')
                                                <form action="{{ route('post_cat.destroy', $cat->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa bản ghi này không ?')"
                                                        class="btn mr-2 btn-sm btn-danger">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endcan

                                            @can('post.edit')
                                                <button type="button" class="btn btn-success btn-sm edit_cat_post"
                                                    id="{{ $cat->id }}" data-toggle="modal" data-target="#exampleModal">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                            @endcan

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
                <div class="modal-body" id="modal_edit_cat_post">
                    <form id="formUpdateCatPost">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
