@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật
            </div>
            <div class="card-body">
                <form enctype="multipart/form-data" action="{{ route('slider.update', $slider->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Tên</label>
                        <input class="form-control @error('title') is-invalid @enderror" type="text" name="title"
                            id="name" value="{{ $slider->title }}">
                        @error('title')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="link">Đường dẫn</label>
                        <input class="form-control @error('link') is-invalid @enderror" type="text" name="link"
                            id="link" value="{{ $slider->link }}">
                        @error('link')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="img">Ảnh slider</label>
                        <input class="form-control @error('img') is-invalid @enderror" type="file" name="img"
                            id="img" hidden>
                        <div class="preview__avatar">
                            <div class="img_container">
                                <img src="{{ asset($slider->img) }}" alt="">
                                <div class="edit_container">
                                    <div class="btn_edit" onclick="editAvatar()">
                                        <i class="fa-solid fa-pen"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @error('img')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status0"
                                        value="0" {{ $slider->status === 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status0">
                                        Chờ duyệt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status1"
                                        value="1" {{ $slider->status === 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status1">
                                        Công khai
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Thuộc loại</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type_img" id="type_img0"
                                        value="slider" {{ $slider->type_img === 'slider' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="type_img0">
                                        Slider
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type_img" id="type_img1"
                                        value="banner" {{ $slider->type_img === 'banner' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="type_img1">
                                        Banner
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary">Cập nhật</button>

            </div>
            </form>
        </div>
    </div>
    </div>
@endsection
