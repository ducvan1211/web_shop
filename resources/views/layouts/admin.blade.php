<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/solid.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="//cdn.ckeditor.com/4.21.0/full/ckeditor.js"></script>

    <title>Admintrator</title>
</head>

<body>
    @php
        $module_active = session('module_active');
    @endphp
    <div id="warpper" class="nav-fixed">
        <nav class="topnav shadow navbar-light bg-white d-flex">
            <div class="navbar-brand"><a href="{{ route('admin') }}">UNITOP ADMIN</a></div>
            <div class="nav-right ">
                <div class="btn-group mr-auto">
                    <button type="button" class="btn dropdown" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="plus-icon fas fa-plus-circle"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('post.create') }}">Thêm bài viết</a>
                        <a class="dropdown-item" href="{{ route('product.create') }}">Thêm sản phẩm</a>
                    </div>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        {{-- <a class="dropdown-item" href="#">Tài khoản</a> --}}
                        {{-- <a class="dropdown-item" href="#">Thoát</a> --}}
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            Thoát
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        <!-- end nav  -->
        <div id="page-body" class="d-flex">
            <div id="sidebar" class="bg-white">
                <ul id="sidebar-menu">
                    <li class="nav-link {{ $module_active == 'dashboard' ? 'active' : '' }}">
                        <a href="{{ route('admin') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Dashboard
                        </a>
                    </li>
                    @canany(['page.edit', 'page.view', 'page.delete', 'page.add'])
                        <li class="nav-link {{ $module_active == 'page' ? 'active' : '' }}">
                            <a href="{{ route('page.index') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Trang
                            </a>


                            <ul class="sub-menu">
                                @can('page.add')
                                    <li><a href="{{ route('page.create') }}">Thêm mới</a></li>
                                @endcan
                                <li><a href="{{ route('page.index') }}">Danh sách</a></li>
                            </ul>
                        </li>
                    @endcanany
                    @canany(['post.edit', 'post.view', 'post.delete', 'post.add'])
                        <li class="nav-link {{ $module_active == 'post' ? 'active' : '' }}">
                            <a href="{{ route('post.index') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Bài viết
                            </a>

                            <ul class="sub-menu">
                                <li><a href="{{ route('post.index') }}">Danh sách</a></li>
                                <li><a href="{{ route('post.create') }}">Thêm mới</a></li>
                                <li><a href="{{ route('post_cat.index') }}">Danh mục</a></li>
                            </ul>
                        </li>
                    @endcanany

                    @canany(['product.edit', 'product.view', 'product.delete', 'product.add'])
                        <li class="nav-link {{ $module_active == 'product' ? 'active' : '' }}">
                            <a href="{{ route('product.index') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Sản phẩm
                            </a>

                            <ul class="sub-menu">
                                <li><a href="{{ route('product.index') }}">Danh sách</a></li>
                                <li><a href="{{ route('product.create') }}">Thêm mới</a></li>
                                <li><a href="{{ route('cat_product.index') }}">Danh mục</a></li>
                                <li><a href="{{ route('brand.index') }}">Thương hiệu</a></li>
                                <li><a href="{{ route('color.index') }}">Màu sắc</a></li>
                                <li><a href="{{ route('configuration.index') }}">Cấu hình sản phẩm</a></li>
                            </ul>
                        </li>
                    @endcanany
                    <li class="nav-link {{ $module_active == 'order' ? 'active' : '' }}">
                        <a href="{{ route('admin.order') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Bán hàng
                        </a>

                        <ul class="sub-menu">
                            <li><a href="{{ route('admin.order') }}">Đơn hàng</a></li>
                        </ul>
                    </li>
                    @canany(['user.edit', 'user.view', 'user.delete', 'user.add'])
                        <li class="nav-link {{ $module_active == 'user' ? 'active' : '' }}">
                            <a href="{{ route('user.index') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Users
                            </a>


                            <ul class="sub-menu">
                                <li><a href="{{ route('user.create') }}">Thêm mới</a></li>
                                <li><a href="{{ route('user.index') }}">Danh sách</a></li>
                            </ul>
                        </li>
                    @endcanany
                    @canany(['slider.edit', 'slider.view', 'slider.delete', 'slider.add'])
                        <li class="nav-link {{ $module_active == 'slider' ? 'active' : '' }}">
                            <a href="{{ route('slider.index') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Sliders
                            </a>


                            <ul class="sub-menu">
                                <li><a href="{{ route('slider.create') }}">Thêm mới</a></li>
                                <li><a href="{{ route('slider.index') }}">Danh sách</a></li>
                            </ul>
                        </li>
                    @endcanany

                    @canany(['role.edit', 'role.view', 'role.delete', 'role.add', 'permission.view', 'permission.add',
                        'permission.edit', 'permission.delete'])
                        <li class="nav-link {{ $module_active == 'roles' ? 'active' : '' }}">
                            <a href="{{ route('role.index') }}">
                                <div class="nav-link-icon d-inline-flex">
                                    <i class="far fa-folder"></i>
                                </div>
                                Phân quyền
                            </a>

                            <ul class="sub-menu">
                                <li><a href="{{ route('permission.add') }}">Quyền</a></li>
                                <li><a href="{{ route('role.create') }}">Thêm vai trò</a></li>
                                <li><a href="{{ route('role.index') }}">Danh sách vai trò</a></li>
                            </ul>
                        </li>
                    @endcanany


                </ul>
            </div>
            <div id="wp-content">
                @yield('content')
            </div>
        </div>


    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script src="{{ asset('js/app.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor 4
        // instance, using default configuration.
        CKEDITOR.replace('intro');
        CKEDITOR.replace('desc');
    </script>
</body>

</html>
