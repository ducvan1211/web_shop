<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = Color::orderBy('title')->get();
        // return $colors;
        return view('admin.color.index', compact('colors'));
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
                    'title' => 'required|unique:colors',
                ],
                [
                    'required' => 'Vui lòng nhập màu sắc',
                    'unique' => 'Dữ liệu đã tồng tại trong hệ thống'
                ]
            );
            $data = $request->all();
            Color::create($data);
            return redirect()->route('color.index')->with('status', 'Thêm dữ liệu thành công');
        } else {
            return redirect()->route('color.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
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
            $color = Color::find($id);
            $color->delete();
            return redirect()->route('color.index')->with('status', 'Xóa dữ liệu thành công');
        } else {
            return redirect()->route('color.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
}
