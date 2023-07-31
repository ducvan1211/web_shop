@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật thông tin người dùng
            </div>
            <div class="card-body">
                <form action="{{ route('user.update', $user->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <input value="{{ $user->name }}" class="form-control @error('name') is-invalid @enderror"
                            type="text" name="name" id="name">
                        @error('name')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input value="{{ $user->email }}" disabled
                            class="form-control @error('email') is-invalid @enderror" type="text" name="email"
                            id="email">
                        @error('email')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password"
                            id="password">
                        @error('password')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Xác nhận mật khẩu</label>
                        <input class="form-control" type="password" name="password_confirmation" id="password-confirm">
                    </div> --}}
                    <div class="form-group">
                        <div>
                            <label for="">Vai trò</label>
                        </div>
                        @foreach ($roles as $role)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="role_{{ $role->id }}"
                                    value="{{ $role->id }}" name="roles[{{ $role->id }}]"
                                    @foreach ($user_roles as $item)
                                        {{ $item->id === $role->id ? 'checked' : '' }} @endforeach>
                                <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                        @endforeach
                        @error('roles')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" name="update" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
