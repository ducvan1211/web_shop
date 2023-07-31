<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
// include '../web_shop/helper_func/function.php';

class AdminBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::with('categories')->orderBy('id', 'DESC')->get();
        // return $brands;
        $cats = Arr::data_tree(Category::where('status', '1')->get());
        return view('admin.brand.index', compact('brands', 'cats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::allows('product.edit') || Gate::allows('product.add')) {
            $request->validate(
                [
                    'b_title' => 'required|string|unique:brands',
                    'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ],
                [
                    'required' => ':attribute không được để trống',
                    'mimes' => 'File hình ảnh có định dạng JPEG, PNG, JPG, GIF, SVG',
                ],
                [
                    'b_title' => 'Tên thương hiệu',
                    'img' => 'Hình ảnh'
                ]
            );

            if ($request->hasFile('img')) {
                $img = $request->img;
                $file_name = time() . '_' . $img->getClientOriginalName();
                $storedPath = $img->move('uploads/', $file_name);
            }
            // return $storedPath;
            $data = $request->all();
            $data['img'] = $storedPath;
            $data['slug'] =  Str::slug($data['b_title'], '-');
            $brand = Brand::create($data);
            $brand->categories()->attach($data['cats']);
            return redirect()->route('brand.index')->with('status', 'Thêm danh mục thành công');
        } else {
            return redirect()->route('brand.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::allows('product.edit') || Gate::allows('product.add')) {
            $brand = Brand::find($id);
            unlink('public/' . $brand['img']);
            $brand->delete();
            return redirect()->route('brand.index')->with('status', 'Xóa danh mục thành công');
        } else {
            return redirect()->route('brand.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
}
