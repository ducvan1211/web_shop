@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật trang
            </div>
            <div class="card-body">
                <form action="{{ route('page.update', $page->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="title">Tiêu đề trang</label>
                        <input class="form-control" type="text" name="title" id="title" value="{{ $page->title }}">
                        @error('title')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung trang</label>
                        <textarea name="content" class="form-control" id="desc" cols="30" rows="5">{!! $page->content !!}</textarea>
                        @error('content')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input {{ $page->status === '0' ? 'checked' : '' }} class="form-check-input" type="radio"
                                name="status" id="status_1" value="0">
                            <label class="form-check-label" for="status_1">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input {{ $page->status === '1' ? 'checked' : '' }} class="form-check-input" type="radio"
                                name="status" id="status_2" value="1">
                            <label class="form-check-label" for="status_2">
                                Công khai
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
