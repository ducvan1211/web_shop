<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;


class AdminCategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cats_public = Category::where('status', '1')->get();
        $cats = Arr::data_tree(Category::all());
        return $cats;
        return view('admin.cat_product.index', compact('cats', 'cats_public'));
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
                    'title' => 'required|string|unique:categories',
                ],
                [
                    'required' => ':attribute không được để trống',
                    'unique' => 'Dữ liệu đã tồn tại trong hệ thống'
                ],
                [
                    'title' => 'Tên danh mục'
                ]
            );
            $data = $request->all();
            $data['slug'] =  Str::slug($data['title'], '-');
            Category::create($data);
            return redirect()->route('cat_product.index')->with('status', 'Thêm danh mục thành công');
        } else {
            return redirect()->route('cat_product.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
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
            $cat = Category::find($id);
            $cat->delete();
            return redirect()->route('cat_product.index')->with('status', 'Xóa danh mục thành công');
        } else {
            return redirect()->route('cat_product.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
}
