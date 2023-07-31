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
                    <div class="card-header font-weight-bold">
                        Cập nhật quyền
                    </div>
                    <div class="card-body">
                        <form action="{{ route('permission.update', $permission->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên quyền</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text"
                                    name="name" id="name" value="{{ $permission->name }}">
                                @error('name')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <small class="form-text text-muted pb-2">Ví dụ: post.add</small>
                                <input class="form-control @error('slug') is-invalid @enderror" type="text"
                                    name="slug" id="slug" value="{{ $permission->slug }}">
                                @error('slug')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Mô tả</label>
                                <textarea class="form-control" type="text" name="description" id="description"> {{ $permission->description }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh sách quyền
                    </div>
                    <div class="card-body">
                        <table class="table table-striped list">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên quyền</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Tác vụ</th>
                                    <!-- <th scope="col">Mô tả</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($permissions as $module => $values)
                                    <tr class="item">
                                        <td scope="row"></td>
                                        <td><strong>Module {{ ucfirst($module) }}</strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @foreach ($values as $value)
                                        @php
                                            $i++;
                                        @endphp
                                        <tr class="item">
                                            <td scope="row">{{ $i }}</td>
                                            <td>|---{{ $value->name }}</td>
                                            <td>{{ $value->slug }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('permission.edit', $value->id) }}"
                                                        class="btn btn-success btn-sm mr-2" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Bạn có chắc chắn xóa bản ghi này không ?')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
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
@endsection
