@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm hình ảnh
            </div>
            <div class="card-body">
                <form enctype="multipart/form-data" action="{{ route('slider.store') }}" method="POST">
                    @csrf
                    @method('POST')

                    <div class="form-group">
                        <label for="name">Tên </label>
                        <input class="form-control @error('title') is-invalid @enderror" type="text" name="title"
                            id="name" value="{{ old('title') }}">
                        @error('title')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="link">Đường dẫn</label>
                        <input class="form-control @error('link') is-invalid @enderror" type="text" name="link"
                            id="link" value="{{ old('link') }}">
                        @error('link')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="img">Ảnh</label>
                        <input class="form-control @error('img') is-invalid @enderror" type="file" name="img"
                            id="img" hidden>
                        <div class="preview__avatar">
                            <div class="btn_add_avatar">
                                <i class="fa-solid fa-plus"></i>
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
                                        value="0">
                                    <label class="form-check-label" for="status0">
                                        Chờ duyệt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status1"
                                        value="1" checked>
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
                                        value="slider">
                                    <label class="form-check-label" for="type_img0">
                                        Slider
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type_img" id="type_img1"
                                        value="banner" checked>
                                    <label class="form-check-label" for="type_img1">
                                        Banner
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary">Thêm mới</button>

            </div>
            </form>
        </div>
    </div>
    </div>
@endsection
