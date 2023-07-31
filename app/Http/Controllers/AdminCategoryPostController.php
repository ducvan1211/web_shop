<?php

namespace App\Http\Controllers;

use App\Models\CategoryPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;



class AdminCategoryPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cats = Arr::data_tree(CategoryPost::all());
        // return $cats;
        $cat_publics = CategoryPost::where('status', '1')->get();
        return view('admin.cat_post.index', compact('cats', 'cat_publics'));
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
        if (Gate::allows('post.edit') || Gate::allows('post.add')) {
            $request->validate(
                [
                    'title' => 'required',
                ],
                [
                    'required' => 'Dữ liệu không được để trống'
                ]
            );
            $data = $request->all();
            $data['slug'] = Str::slug($data['title'], '-');
            $data['parent_id'] = (int) $data['parent_id'];
            CategoryPost::create($data);
            return redirect()->route('post_cat.index')->with('status', 'Thêm dữ liệu thành công');
        } else {
            return redirect()->route('post_cat.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
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
        if (Gate::allows('post.edit') || Gate::allows('post.add')) {
            $cat = CategoryPost::find($id);
            $cat->delete();
            return redirect()->route('post_cat.index')->with('status', 'Xóa dữ liệu thành công');
        } else {
            return redirect()->route('post_cat.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
}
