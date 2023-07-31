<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class AdminPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'page']);
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        $actions = [
            'public' => 'Công khai',
            'pending' => 'Chờ duyệt',
            'delete' => 'Xóa bài viết'
        ];
        $status = $request->status;
        $keyword = '';
        if ($request['s']) {
            $keyword = $request['s'];
        }
        if ($status) {
            if ($status === 'public') {
                $pages = Page::with('user')->where('status', '1')->where('title', "LIKE", "%$keyword%")->orderBy('id', 'DESC')->get();
            } elseif ($status === 'pending') {
                $pages = Page::with('user')->where('status', '0')->where('title', "LIKE", "%$keyword%")->orderBy('id', 'DESC')->get();
            } else {
                $pages = Page::with('user')->where('title', "LIKE", "%$keyword%")->orderBy('id', 'DESC')->get();
            }
        } else {
            $pages = Page::with('user')->where('title', "LIKE", "%$keyword%")->orderBy('id', 'DESC')->get();
        }
        $count['all'] = Page::count();
        $count['public'] = Page::where('status', '1')->count();
        $count['pending'] = Page::where('status', '0')->count();
        return view('admin.pages.index', compact('pages', 'count', 'actions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::allows('page.add')) {
            $request->validate(
                [
                    'title' => 'required|string|max:255',
                    'content' => 'required',
                    // 'cats' => 'required',
                ],
                [
                    'required' => ':attribute không được để trống',
                ],
                [
                    'title' => 'Tên sản phẩm',
                    'content' => 'Nội dung sản phẩm',
                ]
            );
            $data = $request->all();
            $data['slug'] = Str::slug($data['title'], '-');
            $data['user_id'] = Auth::user()->id;
            Page::create($data);
            return redirect()->route('page.index')->with('status', 'Thêm trang thành công');
        } else {
            return redirect()->route('page.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
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
        $page = Page::find($id);
        return view('admin.pages.edit', compact('page'));
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
        if (Gate::allows('page.update')) {
            $page = Page::find($id);
            $request->validate(
                [
                    'title' => 'required|string|max:255',
                    'content' => 'required',
                    // 'cats' => 'required',
                ],
                [
                    'required' => ':attribute không được để trống',
                ],
                [
                    'title' => 'Tên sản phẩm',
                    'content' => 'Nội dung sản phẩm',
                ]
            );
            $data = $request->all();
            $data['slug'] = Str::slug($data['title'], '-');
            $page->update($data);
            return redirect()->route('page.index')->with('status', 'Cập nhật trang thành công');
        } else {
            return redirect()->route('page.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
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
        if (Gate::allows('page.delete')) {
            $page = Page::find($id);
            $page->delete();
            return redirect()->route('page.index')->with('status', 'Xóa trang thành công');
        } else {
            return redirect()->route('page.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
    public function action(Request $request)
    {
        if (Gate::allows('page.delete')) {
            $action = $request->action;
            $checks = $request->checks;
            if (empty($checks)) {
                return redirect()->route('page.index')->with('status', 'Vui lòng chọn bài viết');
            }
            if ($action) {
                if ($action === 'public') {
                    foreach ($checks as $id => $v) {
                        $page = Page::find($id);
                        $page->update(
                            ['status' => '1']
                        );
                    }
                    return redirect()->route('page.index')->with('status', 'Cập nhật bài viết thành công');
                } elseif ($action === 'pending') {
                    foreach ($checks as $id => $v) {
                        $page = Page::find($id);
                        $page->update(
                            ['status' => '0']
                        );
                    }
                    return redirect()->route('page.index')->with('status', 'Cập nhật bài viết thành công');
                } elseif ($action === 'delete') {
                    foreach ($checks as $id => $v) {
                        $page = Page::find($id);
                        $page->delete();
                    }
                    return redirect()->route('page.index')->with('status', 'Xóa bài thành công');
                } else {
                    return redirect()->route('page.index')->with('status', 'Vui lòng chọn trạng thái');
                }
            }
        } else {
            return redirect()->route('page.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
}
