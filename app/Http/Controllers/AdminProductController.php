<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\ConfigurationType;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
// use Helper_func\Data_tree;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        $status = $request->status;
        $actions = [
            'stocking' => 'Còn hàng',
            'out_stock' => 'Hết hàng',
            'public' => 'Công khai',
            'pending' => 'Chờ duyệt',
            'delete' => 'Xóa sản phẩm'
        ];
        $keyword = '';
        if ($request['s']) {
            $keyword = $request['s'];
        }
        if ($status) {
            if ($status === 'stocking') {
                $products = Product::with('colors', 'categories', 'brand')->where('is_stocking', '1')->where('title', 'LIKE', "%$keyword%")->orderby('id')->get();
            } elseif ($status === 'out_stock') {
                $products = Product::with('colors', 'categories', 'brand')->where('is_stocking', '0')->where('title', 'LIKE', "%$keyword%")->orderby('id')->get();
            } elseif ($status === 'public') {
                $products = Product::with('colors', 'categories', 'brand')->where('status', '1')->where('title', 'LIKE', "%$keyword%")->orderby('id')->get();
            } elseif ($status === 'pending') {
                $products = Product::with('colors', 'categories', 'brand')->where('status', '0')->where('title', 'LIKE', "%$keyword%")->orderby('id')->get();
            }
        } else {
            $products = Product::with('colors', 'categories', 'brand')->where('title', 'LIKE', "%$keyword%")->orderby('id')->get();
        }
        $count['stocking'] = Product::where('is_stocking', '1')->count();
        $count['out_stock'] = Product::where('is_stocking', '0')->count();
        $count['all'] = Product::count();
        $count['public'] = Product::where('status', '1')->count();
        $count['pending'] = Product::where('status', '0')->count();

        return view('admin.products.index', compact('products', 'count', 'actions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::where('status', '1')->orderby('b_title')->get();
        $cats = Arr::data_tree(Category::where('status', '1')->get());
        // $cats = Category::where('status', '1')->orderby('title')->get();
        $colors = Color::where('status', '1')->orderby('title')->get();
        $types = ConfigurationType::where('status', '1')->orderby('title')->get();
        return view('admin.products.create', compact('brands', 'cats', 'colors', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::allows('product.add')) {
            $request->validate(
                [
                    'title' => 'required|string|max:255',
                    'desc' => 'required',
                    'content' => 'required',
                    'price' => 'required|numeric',
                    'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'cats' => 'required',
                    'colors' => 'required',
                    'brand_id' => 'required',
                ],
                [
                    'required' => ':attribute không được để trống',
                    'numeric' => ' :attribute phải nhập dữ liệu sô',
                    'image' => 'Vui lòng chọn file ảnh',
                    'img' => 'Vui lòng chọn file ảnh'
                ],
                [
                    'title' => 'Tên sản phẩm',
                    'desc' => 'Mô tả sản phẩm',
                    'content' => 'Nội dung sản phẩm',
                    'price' => 'Giá sản phẩm',
                    'img' => 'Ảnh đại diện sản phẩm',
                    'images' => 'Danh sách ảnh sản phẩm',
                    'cats' => 'Danh mục sản phẩm',
                    'colors' => 'Màu sắc sản phẩm',
                    'brand_id' => 'Thương hiệu sản phẩm'
                ]
            );
            $data = $request->all();
            $data['slug'] = Str::slug($data['title'], '-');

            if ($data['config_id'] !== '8') {
                $data['config'] = json_encode($data['config'], JSON_UNESCAPED_UNICODE);
            }
            $file = $request->img;
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move('uploads', $file_name);
            $data['img'] = 'uploads/' . $file_name;

            $data['brand_id'] = (int)$data['brand_id'];
            $data['config_id'] = (int)$data['config_id'];


            $product = Product::create($data);
            $images = [];
            foreach ($data['images'] as $image) {
                $image_name = time() . '_' . $image->getClientOriginalName();
                $image->move('uploads', $image_name);
                Image::create(
                    [
                        'product_id' => $product->id,
                        'image' => 'uploads/' . $image_name,
                    ]
                );
            }
            $product->colors()->attach($data['colors']);
            $product->categories()->attach($data['cats']);
            return redirect()->route('product.index')->with('status', 'Thêm sản phẩm thành công');
        } else {
            return redirect()->route('product.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $product = Product::with('images', 'colors', 'categories', 'brand')->where('id', $id)->first();
        $attributes = false;
        if ($product['config_id'] !== 8) {
            $attributes = json_decode($product['config']);
        }
        // return $attributes;

        $brands = Brand::where('status', '1')->orderby('b_title')->get();
        $cats = Arr::data_tree(Category::where('status', '1')->get());

        // $cats = Category::where('status', '1')->orderby('title')->get();
        $colors = Color::where('status', '1')->orderby('title')->get();
        $types = ConfigurationType::where('status', '1')->orderby('title')->get();
        return view('admin.products.edit', compact('brands', 'cats', 'colors', 'types', 'product', 'attributes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Gate::allows('product.edit')) {
            $list_img = $request->session()->get('list_id');
            if ($list_img) {
                $arr = array();
                foreach ($list_img as $item) {
                    $id_img = (int)$item;
                    $img = Image::find($id_img);
                    unlink('public/' . $img->image);
                    $img->delete();
                }
            }
            $product = Product::with('images', 'colors', 'categories', 'brand')->where('id', $id)->first();
            $request->validate(
                [
                    'title' => 'required|string|max:255',
                    'desc' => 'required',
                    'content' => 'required',
                    'price' => 'required|numeric',
                    'img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'cats' => 'required',
                    'colors' => 'required',
                    'brand_id' => 'required',
                ],
                [
                    'required' => ':attribute không được để trống',
                    'numeric' => ' :attribute phải nhập dữ liệu sô',
                    'image' => 'Vui lòng chọn file ảnh',
                    'img' => 'Vui lòng chọn file ảnh'
                ],
                [
                    'title' => 'Tên sản phẩm',
                    'desc' => 'Mô tả sản phẩm',
                    'content' => 'Nội dung sản phẩm',
                    'price' => 'Giá sản phẩm',
                    'img' => 'Ảnh đại diện sản phẩm',
                    'images' => 'Danh sách ảnh sản phẩm',
                    'cats' => 'Danh mục sản phẩm',
                    'colors' => 'Màu sắc sản phẩm',
                    'brand_id' => 'Thương hiệu sản phẩm'
                ]
            );
            $data = $request->all();
            $data['slug'] = Str::slug($data['title'], '-');
            if ($request->hasFile('img')) {
                $file = $request->img;
                $file_name = time() . '_' . $file->getClientOriginalName();
                $file->move('uploads', $file_name);
                $data['img'] = 'uploads/' . $file_name;
                unlink('public/' . $product->img);
            }

            if ($data['config'] !== '8') {
                $data['config'] = json_encode($data['config'], JSON_UNESCAPED_UNICODE);
            }
            $data['brand_id'] = (int)$data['brand_id'];
            $data['config_id'] = (int)$data['config_id'];
            $product->update($data);
            if (isset($data['images'])) {
                foreach ($data['images'] as $image) {
                    $image_name = time() . '_' . $image->getClientOriginalName();
                    $image->move('uploads', $image_name);
                    Image::create(
                        [
                            'product_id' => $product->id,
                            'image' => 'uploads/' . $image_name,
                        ]
                    );
                }
            }

            $product->colors()->sync($data['colors']);
            $product->categories()->sync($data['cats']);
            return redirect()->route('product.index')->with('status', 'Cập nhật sản phẩm thành công');
        } else {
            return redirect()->route('product.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
    public function delete($id)
    {
        if (Gate::allows('product.delete')) {
            $product = Product::find($id);
            $images = $product->images;
            foreach ($images as $img) {
                unlink('public/' . $img->image);
            }
            // return $images;
            unlink('public/' . $product->img);
            $product->delete();
            return redirect()->route('product.index')->with('status', 'Xóa sản phẩm thành công');
        } else {
            return redirect()->route('product.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
    public function action(Request $request)
    {
        if (Gate::allows('product.edit')) {
            $action = $request->action;
            $checks = $request->checks;
            if (empty($checks)) {
                return redirect()->route('product.index')->with('status', 'Vui lòng chọn sản phẩm');
            }
            if ($action) {
                if ($action === 'stocking') {
                    foreach ($checks as $id => $v) {
                        $product = Product::find($id);
                        $product->update(
                            ['is_stocking' => '1']
                        );
                    }
                    return redirect()->route('product.index')->with('status', 'Cập nhật sản phẩm thành công');
                } elseif ($action === 'out_stock') {
                    foreach ($checks as $id => $v) {
                        $product = Product::find($id);
                        $product->update(
                            ['is_stocking' => '0']
                        );
                    }
                    return redirect()->route('product.index')->with('status', 'Cập nhật sản phẩm thành công');
                } elseif ($action === 'public') {
                    foreach ($checks as $id => $v) {
                        $product = Product::find($id);
                        $product->update(
                            ['status' => '1']
                        );
                    }
                    return redirect()->route('product.index')->with('status', 'Cập nhật sản phẩm thành công');
                } elseif ($action === 'pending') {
                    foreach ($checks as $id => $v) {
                        $product = Product::find($id);
                        $product->update(
                            ['status' => '0']
                        );
                    }
                    return redirect()->route('product.index')->with('status', 'Cập nhật sản phẩm thành công');
                } elseif ($action === 'delete') {
                    foreach ($checks as $id => $v) {
                        $product = Product::find($id);
                        $images = $product->images;
                        foreach ($images as $img) {
                            unlink('public/' . $img->image);
                        }
                        unlink($product->img);
                        $product->delete();
                    }
                    return redirect()->route('product.index')->with('status', 'Xóa sản phẩm thành công');
                } else {
                    return redirect()->route('product.index')->with('status', 'Vui lòng chọn trạng thái');
                }
            }
        } else {
            return redirect()->route('product.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
}
