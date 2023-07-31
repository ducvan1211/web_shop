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
                <h5 class="m-0 ">Danh sách bài viết</h5>
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
                    <a href="{{ route('post.index') }}" class="text-primary">Tất cả<span
                            class="text-muted">({{ $count['all'] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'public']) }}" class="text-primary">Công khai<span
                            class="text-muted">({{ $count['public'] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="text-primary">Chờ duyệt<span
                            class="text-muted">({{ $count['pending'] }})</span></a>
                </div>
                <form action="{{ route('post.action') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-action form-inline py-3">
                                <select class="form-control mr-1" id="" name="action">
                                    <option>Chọn</option>
                                    @foreach ($actions as $k => $action)
                                        <option value="{{ $k }}">{{ $action }}</option>
                                    @endforeach
                                </select>
                                <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                            </div>
                        </div>
                        <div class="col-6 text-right d-flex justify-content-end align-items-center">
                            <a href="{{ route('post.create') }}" class="btn btn-primary">Thêm
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
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Người tạo</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($posts as $post)
                                @php
                                    $i++;
                                @endphp
                                <tr class="item">
                                    <td>
                                        <input type="checkbox" name="checks[{{ $post->id }}]">
                                    </td>
                                    <td scope="row">{{ $i }}</td>
                                    <td><img style="width: 80px;height:80px;object-fit:contain"
                                            src="{{ asset($post->img) }}" alt=""></td>
                                    <td>
                                        <a href="{{ route('post.edit', $post->id) }}">{{ $post->title }}</a>
                                    </td>
                                    <td>
                                        @foreach ($post->categories as $cat)
                                            <span class="badge badge-success">{{ $cat->title }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>
                                        @if ($post->status === '1')
                                            <span class="badge badge-success">Công khai</span>
                                        @else
                                            <span class="badge badge-danger">Chờ duyệt</span>
                                        @endif
                                    </td>
                                    <td>{{ $post->created_at }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('post.edit', $post->id) }}"
                                                class="btn btn-success btn-sm mr-2" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            @can('post.delete')
                                                <a href="{{ route('post.delete', $post->id) }}" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Bạn có chắc chắn xóa bản ghi này không ?')">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            @endcan

                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        <ul class="listPage">

                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
