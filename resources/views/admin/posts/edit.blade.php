@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật bài viết
            </div>
            <div class="card-body">
                <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name">Tiêu đề bài viết</label>
                        <input class="form-control" type="text" name="title" id="name"
                            value="{{ $post->title }}">
                        @error('title')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="desc">Mô tả bài viết</label>
                        <textarea name="desc" class="form-control" id="desc" cols="30" rows="5">{!! $post->desc !!}</textarea>
                        @error('desc')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="intro">Nội dung bài viết</label>
                        <textarea name="content" class="form-control" id="intro" cols="30" rows="5">{!! $post->content !!}</textarea>
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
                                <input
                                    @foreach ($post->categories as $category)
                                {{ $category->id === $cat->id ? 'checked' : '' }} @endforeach
                                    class="form-check-input" type="checkbox" id="cat_{{ $cat->id }}"
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
                            <div class="img_container">
                                <img src="{{ asset($post->img) }}" alt="">
                                <div class="edit_container">
                                    <div class="btn_edit" onclick="editAvatar()">
                                        <i class="fa-solid fa-pen"></i>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <div class="form-check">
                                <input {{ $post->status === '0' ? 'checked' : '' }} class="form-check-input" type="radio"
                                    name="status" id="status0" value="0">
                                <label class="form-check-label" for="status0">
                                    Chờ duyệt
                                </label>
                            </div>
                            <div class="form-check">
                                <input {{ $post->status === '1' ? 'checked' : '' }} class="form-check-input" type="radio"
                                    name="status" id="status1" value="1">
                                <label class="form-check-label" for="status1">
                                    Công khai
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
