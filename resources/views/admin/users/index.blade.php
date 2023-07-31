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
                <h5 class="m-0 ">Danh sách thành viên</h5>
                <div class="form-search form-inline">
                    <form class="d-flex" action="{{ route('user.index') }}" method="GET">
                        <input type="text" class="form-control form-search " name="s" style="margin-left: -10px"
                            placeholder="Tìm kiếm" value="{{ request()->input('s') }}">
                        <input style="margin-left: 10px" type="submit" name="btn-search" value="Tìm kiếm"
                            class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Kích hoạt<span
                            class="text-muted">({{ $count['active'] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Vô hiệu
                        hóa<span class="text-muted">({{ $count['trash'] }})</span></a>
                </div>
                <form action="{{ route('user.action') }}" method="POST">
                    @method('POST')
                    @csrf
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id="" name="action">
                            <option>Chọn</option>
                            @foreach ($actions as $key => $action)
                                <option value="{{ $key }}">{{ $action }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn-apply" value="Áp dụng" class="btn btn-primary">
                    </div>
                    <table class="table table-striped table-checkall" style="overflow: scroll">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="checkall">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Họ tên</th>
                                <th scope="col">Email</th>
                                <th scope="col">Vai trò</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody class="list">

                            @if ($users->count() > 0)
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($users as $user)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr class="item">
                                        <td>
                                            @if (Auth::id() !== $user->id)
                                                <input type="checkbox" name="checks[{{ $user->id }}]"
                                                    value="{{ $user->id }}">
                                            @endif
                                        </td>
                                        <th scope="row">{{ $i }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                                <span class="badge badge-primary">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>{{ $user->created_at }}</td>
                                        <td class="d-flex">
                                            @if (request()->input('status') !== 'trash')
                                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-success">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                            @can('user.delete')
                                                @if (request()->input('status') === 'trash')
                                                    <a href="{{ route('user.restore', $user->id) }}" title="Khôi phục"
                                                        class=" btn btn-warning"><i class="fas fa-trash-restore"></i></a>
                                                @endif
                                                @if (Auth::user()->id !== $user->id)
                                                    <a href="
                                        @if (request()->input('status') === 'trash') {{ route('user.force_delele', $user->id) }}
                                        @else{{ route('user.delete', $user->id) }} @endif"
                                                        onclick="return confirm('Bạn có chắc chắn xóa bản ghi này ?')"
                                                        class="btn ml-2 btn-danger"><i class="fa fa-trash"></i></a>
                                                @endif
                                            @endcan


                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center" colspan="7">Không tìm thấy bản ghi</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </form>
                <div class="d-flex justify-content-center">
                    <ul class="listPage">

                    </ul>
                </div>
                {{-- {{ $users->links() }} --}}
            </div>
        </div>
    </div>
@endsection
