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
                <h5 class="m-0 ">Danh sách vai trò</h5>
                {{-- <div class="form-search form-inline">
                    <form class="d-flex" style="margin-left:-10px" action="#">
                        <input type="text" style="margin-right:10px" class="form-control form-search"
                            placeholder="Tìm kiếm" name="s" value="{{ request()->input('s') }}">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div> --}}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        {{-- <div class="form-action form-inline py-3">
                            <select class="form-control mr-1" id="">
                                <option>Chọn</option>
                                <option>Tác vụ 1</option>
                                <option>Tác vụ 2</option>
                            </select>
                            <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                        </div> --}}
                    </div>

                    <div style="padding-bottom: 15px"
                        class="col-6 text-right d-flex justify-content-end align-items-center">
                        <a href="{{ route('role.create') }}" class="btn btn-primary">Thêm
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
                            <th scope="col">Vai trò</th>
                            <th scope="col">Mô tả</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @php
                            $i = 0;
                        @endphp
                        @if ($roles->count() > 0)
                            @foreach ($roles as $role)
                                @php
                                    $i++;
                                @endphp
                                <tr class="item">
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                    <td scope="row">{{ $i }}</td>
                                    <td><a href="{{ route('role.edit', $role->id) }}">{{ $role->name }}</a></td>
                                    <td>{{ $role->description }}</td>
                                    <td>{{ $role->created_at }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('role.edit', $role->id) }}"
                                                class="btn btn-success btn-sm mr-2" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @can('role.delete')
                                                <a href="{{ route('role.delete', $role->id) }}" class="btn btn-sm btn-danger"
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
                                <td colspan="6" class="text-center">không có bản ghi nào</td>
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
