@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm sản phẩm
            </div>
            <div class="card-body">
                <form enctype="multipart/form-data" action="{{ route('product.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <input class="form-control @error('title') is-invalid @enderror" type="text"
                                    name="title" id="name" value="{{ old('title') }}">
                                @error('title')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="price">Giá</label>
                                <input class="form-control @error('price') is-invalid @enderror" type="number"
                                    name="price" id="price" value="{{ old('price') }}">
                                @error('price')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="img">Ảnh đại diện</label>
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
                    <div class="form-group">
                        <label for="image">Danh sách hình ảnh</label>
                        <input class="form-control @error('images') is-invalid @enderror" multiple type="file"
                            name="images[]" id="image" hidden>
                        <div class="preview_imgs">
                            <div class="add_img">
                                <i class="fa-solid fa-plus"></i>

                            </div>
                        </div>
                        @error('images')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="desc">Mô tả sản phẩm</label>
                        <textarea name="desc" class="form-control" id="desc" cols="30" rows="5"> {!! old('desc') !!}</textarea>
                        @error('desc')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="intro">Chi tiết sản phẩm</label>
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
                                <input class="form-check-input" type="checkbox" id="category_{{ $cat->id }}"
                                    value="{{ $cat->id }}" name="cats[{{ $cat->id }}]">
                                <label class="form-check-label"
                                    for="category_{{ $cat->id }}">{{ $cat->title }}</label>
                            </div>
                        @endforeach
                        @error('cats')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="">Màu sắc</label>
                        </div>
                        @foreach ($colors as $color)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="color_{{ $color->id }}"
                                    value="{{ $color->id }}" name="colors[{{ $color->id }}]">
                                <label class="form-check-label"
                                    for="color_{{ $color->id }}">{{ $color->title }}</label>
                            </div>
                        @endforeach
                        @error('colors')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="brand">Thương hiệu</label>
                        <select class="form-control" id="brand" name="brand_id">
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->b_title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="brand">Thuộc cấu hình</label>
                        <select class="form-control" name="config_id" id="config_type">
                            @foreach ($types as $type)
                                <option {{ $type->id === 8 ? 'selected' : '' }} value="{{ $type->id }}">
                                    {{ $type->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="config_details">

                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Hàng trong kho</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_stocking" id="stocking_0"
                                        value="0">
                                    <label class="form-check-label" for="stocking_0">
                                        Hết hàng
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_stocking" id="stocking_1"
                                        value="1" checked>
                                    <label class="form-check-label" for="stocking_1">
                                        Còn hàng
                                    </label>
                                </div>
                            </div>
                        </div>
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
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor 4
        // instance, using default configuration.
        CKEDITOR.replace('intro');
        CKEDITOR.replace('desc');
    </script>
@endsection
