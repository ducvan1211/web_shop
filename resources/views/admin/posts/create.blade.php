@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">

            <div class="card-header font-weight-bold">
                Thêm bài viết
            </div>
            <div class="card-body">
                <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tiêu đề bài viết</label>
                        <input class="form-control" type="text" name="title" id="name"
                            value="{{ old('title') }}">
                        @error('title')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="desc">Mô tả bài viết</label>
                        <textarea name="desc" class="form-control" id="desc" cols="30" rows="5">{!! old('desc') !!}</textarea>
                        @error('desc')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="intro">Nội dung bài viết</label>
                        <textarea name="content" class="form-control" id="intro" cols="30" rows="5">{!! old('content') !!}</textarea>
                        @error('content')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="">Danh mục</label>
                        </div>
                        @foreach ($cats as $cat)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="cat_{{ $cat->id }}"
                                    value="{{ $cat->id }}" name="cats[{{ $cat->id }}]">
                                <label class="form-check-label" for="cat_{{ $cat->id }}">{{ $cat->title }}</label>
                            </div>
                        @endforeach
                        @error('cats')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="img">Ảnh đại diện</label>
                        <input class="form-control" type="file" name="img" id="img" hidden>
                        @error('img')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                        <div class="preview__avatar">
                            <div class="btn_add_avatar">
                                <i class="fa-solid fa-plus"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status1" value="0">
                            <label class="form-check-label" for="status1">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status2" value="1"
                                checked>
                            <label class="form-check-label" for="status2">
                                Công khai
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
