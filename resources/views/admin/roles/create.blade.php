@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Thêm mới vai trò</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('role.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="text-strong" for="name">Tên vai trò</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                            id="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="text-strong" for="description">Mô tả</label>
                        <textarea class="form-control" type="text" name="description" id="description">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <strong>Vai trò này có quyền gì?</strong>
                    <small class="form-text text-muted pb-2">Check vào module hoặc các hành động bên dưới để chọn
                        quyền.</small>
                    <!-- List Permission  -->
                    @error('permission_id')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                    @foreach ($permissions as $key => $module)
                        <div class="card my-4 border">
                            <div class="card-header">
                                <input type="checkbox" class="check-all" name="" id="{{ $key }}">
                                <label for="{{ $key }}" class="m-0">Module {{ $key }}</label>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($module as $permission)
                                        <div class="col-md-3">
                                            <input type="checkbox" class="permission" value="{{ $permission->id }}"
                                                name="permission_id[{{ $permission->id }}]" id="{{ $permission->slug }}">
                                            <label for="{{ $permission->slug }}">{{ $permission->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <input type="submit" name="btn-add" class="btn btn-primary" value="Thêm mới">
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('.check-all').click(function() {
            $(this).closest('.card').find('.permission').prop('checked', this.checked)
        })
    </script>
@endsection
