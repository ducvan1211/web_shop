@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật sản phẩm
            </div>
            <div class="card-body">
                <form enctype="multipart/form-data" action="{{ route('product.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <input class="form-control @error('title') is-invalid @enderror" type="text"
                                    name="title" id="name" value="{{ $product->title }}">
                                @error('title')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="price">Giá</label>
                                <input class="form-control @error('price') is-invalid @enderror" type="number"
                                    name="price" id="price" value="{{ $product->price }}">
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
                        @error('img')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror

                        <div class="preview__avatar">
                            <div class="img_container">
                                <img src="{{ asset($product->img) }}" alt="">
                                <div class="edit_container">
                                    <div class="btn_edit" onclick="editAvatar()">
                                        <i class="fa-solid fa-pen"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image">Danh sách hình ảnh</label>
                        <input class="form-control @error('images') is-invalid @enderror" multiple type="file"
                            name="images[]" id="image" hidden>
                        @error('images')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                        <div class="preview_imgs">
                            <div class="add_img">
                                <i class="fa-solid fa-plus"></i>
                            </div>
                            @foreach ($product->images as $image)
                                <div class="img_item">
                                    <img src="{{ asset($image->image) }}" alt="">
                                    <div class="delete">
                                        <div class="btn__delete" data-id="{{ $image->id }}">
                                            <i class="fa-solid fa-xmark"></i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                    </div>
                    <div class="form-group">
                        <label for="desc">Mô tả sản phẩm</label>
                        <textarea name="desc" class="form-control" id="desc" cols="30" rows="5">{!! $product->desc !!} </textarea>
                        @error('desc')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="intro">Chi tiết sản phẩm</label>
                        <textarea name="content" class="form-control" id="intro" cols="30" rows="5"> {!! $product->content !!}</textarea>
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
                                    @foreach ($product->categories as $category)
                                       {{ $category->id === $cat->id ? 'checked' : '' }} @endforeach
                                    class="form-check-input" type="checkbox" id="category_{{ $cat->id }}"
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
                                <input
                                    @foreach ($product->colors as $item)
                                {{ $item->id === $color->id ? 'checked' : '' }} @endforeach
                                    class="form-check-input" type="checkbox" id="color_{{ $color->id }}"
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
                                <option {{ $product->brand_id === $brand->id ? 'selected' : '' }}
                                    value="{{ $brand->id }}">
                                    {{ $brand->b_title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="brand">Thuộc cấu hình</label>
                        <select class="form-control" id="config_type" name="config_id">
                            <option value="0">Chọn cấu hình</option>
                            @foreach ($types as $type)
                                <option {{ $product->config_id === $type->id ? 'selected' : '' }}
                                    value="{{ $type->id }}">
                                    {{ $type->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if ($attributes)
                        <div class="config_details">
                            @foreach ($attributes as $k => $attr)
                                <div class="form-group">
                                    <label for="{{ $k }}">{{ $k }}</label>
                                    <input class="form-control" type="text" name="config[{{ $k }}]"
                                        id="{{ $k }}" value="{{ $attr }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Hàng trong kho</label>
                                <div class="form-check">
                                    <input {{ $product->is_stocking === '0' ? 'checked' : '' }} class="form-check-input"
                                        type="radio" name="is_stocking" id="stocking_0" value="0">
                                    <label class="form-check-label" for="stocking_0">
                                        Hết hàng
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input {{ $product->is_stocking === '1' ? 'checked' : '' }} class="form-check-input"
                                        type="radio" name="is_stocking" id="stocking_1" value="1" checked>
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
                                    <input {{ $product->status === '0' ? 'checked' : '' }} class="form-check-input"
                                        type="radio" name="status" id="status0" value="0">
                                    <label class="form-check-label" for="status0">
                                        Chờ duyệt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input {{ $product->status === '1' ? 'checked' : '' }} class="form-check-input"
                                        type="radio" name="status" id="status1" value="1" checked>
                                    <label class="form-check-label" for="status1">
                                        Công khai
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
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
