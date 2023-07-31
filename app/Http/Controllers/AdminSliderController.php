<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'slider']);
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        $status = $request->status;
        $keyword = '';
        $actions = [
            'public' => 'Công khai',
            'pending' => 'Chờ duyệt',
            'delete' => 'Xóa slider'
        ];
        if ($request['s']) {
            $keyword = $request['s'];
        }
        if ($status) {
            if ($status === 'public') {
                $sliders = Slider::where('status', 1)->where('title', 'LIKE', "%$keyword%")->orderby('id', 'DESC')->get();
            } elseif ($status === 'pending') {
                $sliders = Slider::where('status', 0)->where('title', 'LIKE', "%$keyword%")->orderby('id', 'DESC')->get();
            } else {
                $sliders = Slider::where('title', 'LIKE', "%$keyword%")->orderby('id', 'DESC')->get();
            }
        } else {
            $sliders = Slider::where('title', 'LIKE', "%$keyword%")->orderby('id', 'DESC')->get();
        }
        $count['all'] = Slider::count();
        $count['public'] = Slider::where('status', 1)->count();
        $count['pending'] = Slider::where('status', 0)->count();
        return view('admin.sliders.index', compact('sliders', 'actions', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::allows('slider.add')) {
        } else {
            return redirect()->route('slider.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'link' => 'required|string|max:255',
                'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            ],
            [
                'required' => ':attribute không được để trống',
                'img' => 'Vui lòng chọn file ảnh'
            ],
            [
                'title' => 'Tên slider',
                'img' => 'Ảnh slider',
                'link' => 'Đường dẫn'
            ]
        );
        $data = $request->all();
        $file = $request->img;
        $file_name = time() . '_' . $file->getClientOriginalName();
        $file->move('uploads', $file_name);
        $data['img'] = 'uploads/' . $file_name;
        $data['status'] = (int)$data['status'];
        $slider = Slider::create($data);
        return redirect()->route('slider.index')->with('status', 'Thêm thành công');
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
        $slider = Slider::find($id);
        return view('admin.sliders.edit', compact('slider'));
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
        if (Gate::allows('slider.add')) {
            $slider = Slider::find($id);
            $request->validate(
                [
                    'title' => 'required|string|max:255',
                    'link' => 'required|string|max:255',

                ],
                [
                    'required' => ':attribute không được để trống',
                    'img' => 'Vui lòng chọn file ảnh'
                ],
                [
                    'title' => 'Tên slider',
                    'img' => 'Ảnh slider',
                    'link' => 'Đường dẫn'
                ]
            );
            $data = $request->all();
            if ($request->hasFile('img')) {
                $file = $request->img;
                $file_name = time() . '_' . $file->getClientOriginalName();
                $file->move('uploads', $file_name);
                $data['img'] = 'uploads/' . $file_name;
                unlink($slider->img);
            }
            $data['status'] = (int)$data['status'];
            $slider->update($data);
            return redirect()->route('slider.index')->with('status', 'Cập nhật thành công');
        } else {
            return redirect()->route('slider.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
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
        //
    }
    function delete($id)
    {
        if (Gate::allows('slider.delete')) {
            $slider = Slider::find($id);
            unlink($slider->img);
            $slider->delete();
            return redirect()->route('slider.index')->with('status', 'Xóa slider thành công');
        } else {
            return redirect()->route('slider.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
    function action(Request $request)
    {
        if (Gate::allows('slider.edit')) {
            $action = $request->action;
            $checks = $request->checks;
            if (empty($checks)) {
                return redirect()->route('slider.index')->with('status', 'Vui lòng chọn slider');
            }
            if ($action) {
                if ($action === 'public') {
                    foreach ($checks as $id => $v) {
                        $slider = Slider::find($id);
                        $slider->update(
                            ['status' => 1]
                        );
                    }
                    return redirect()->route('slider.index')->with('status', 'Cập nhật slider thành công');
                } elseif ($action === 'pending') {
                    foreach ($checks as $id => $v) {
                        $slider = Slider::find($id);
                        $slider->update(
                            ['status' => 0]
                        );
                    }
                    return redirect()->route('slider.index')->with('status', 'Cập nhật slider thành công');
                } elseif ($action === 'delete') {
                    foreach ($checks as $id => $v) {
                        $slider = Slider::find($id);
                        unlink($slider->img);
                        $slider->delete();
                    }
                    return redirect()->route('slider.index')->with('status', 'Xóa slider thành công');
                } else {
                    return redirect()->route('slider.index')->with('status', 'Vui lòng chọn trạng thái');
                }
            } else {
                return redirect()->route('slider.index')->with('status', 'Vui lòng chọn trạng thái');
            }
        } else {
            return redirect()->route('slider.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
}
