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
                        Thêm quyền
                    </div>
                    <div class="card-body">
                        <form action="{{ route('permission.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên quyền</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text"
                                    name="name" id="name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <small class="form-text text-muted pb-2">Ví dụ: post.add</small>
                                <input class="form-control @error('slug') is-invalid @enderror" type="text"
                                    name="slug" id="slug" value="{{ old('slug') }}">
                                @error('slug')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Mô tả</label>
                                <textarea class="form-control" type="text" name="description" id="description"> {{ old('description') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
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
                                    @canany(['permission.edit', 'permission.delete'])
                                        <th scope="col">Tác vụ</th>
                                    @endcanany
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
                                        <!-- <td></td> -->
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
                                                    @can('permission.edit')
                                                        <a href="{{ route('permission.edit', $value->id) }}"
                                                            class="btn btn-success btn-sm mr-2" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan

                                                    @can('permission.delete')
                                                        <a href="{{ route('permission.delete', $value->id) }}"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Bạn có chắc chắn xóa bản ghi này không ?')">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    @endcan

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
