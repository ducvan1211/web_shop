<?php

namespace App\Http\Controllers;

use App\Models\Cat_post;
use App\Models\CategoryPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;


class AdminPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'post']);
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
                $posts = Post::with('categories')->where('status', '1')->where('title', "LIKE", "%$keyword%")->get();
                foreach ($posts as $post) {
                    $post['user'] = User::find($post->user_id);
                }
            } elseif ($status === 'pending') {
                $posts = Post::with('categories')->where('status', '0')->where('title', "LIKE", "%$keyword%")->get();
                foreach ($posts as $post) {
                    $post['user'] = User::find($post->user_id);
                }
            } else {
                $posts = Post::with('categories')->where('title', "LIKE", "%$keyword%")->get();
                foreach ($posts as $post) {
                    $post['user'] = User::find($post->user_id);
                }
            }
        } else {
            $posts = Post::with('categories')->where('title', "LIKE", "%$keyword%")->get();
            foreach ($posts as $post) {
                $post['user'] = User::find($post->user_id);
            }
        }
        $count['all'] = Post::count();
        $count['public'] = Post::where('status', '1')->count();
        $count['pending'] = Post::where('status', '0')->count();
        return view('admin.posts.index', compact('posts', 'count', 'actions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cats = Arr::data_tree(CategoryPost::where('status', '1')->get());
        return view('admin.posts.create', compact('cats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::allows('post.add')) {
            $request->validate(
                [
                    'title' => 'required|string|max:255',
                    'desc' => 'required',
                    'content' => 'required',
                    'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    // 'cats' => 'required',
                ],
                [
                    'required' => ':attribute không được để trống',
                    'image' => 'Vui lòng chọn file ảnh',
                ],
                [
                    'title' => 'Tên sản phẩm',
                    'desc' => 'Mô tả sản phẩm',
                    'content' => 'Nội dung sản phẩm',
                    'img' => 'Ảnh đại diện sản phẩm',
                    'cats' => 'Danh mục sản phẩm',
                ]
            );
            $data = $request->all();
            $data['slug'] = Str::slug($data['title'], '-');
            $file = $request->img;
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move('uploads', $file_name);
            $data['img'] = 'uploads/' . $file_name;
            $data['user_id'] = Auth::user()->id;
            $post = Post::create($data);
            $post->categories()->attach($data['cats']);
            return redirect()->route('post.index')->with('status', 'Thêm bài viết thành công');
        } else {
            return redirect()->route('post.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
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
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::allows('post.edit')) {
            $post = Post::with('categories')->where('id', $id)->first();
            $cats = Arr::data_tree(CategoryPost::where('status', '1')->get());
            return view('admin.posts.edit', compact('post', 'cats'));
        } else {
            return redirect()->route('post.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
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
        $post = Post::with('categories')->where('id', $id)->first();
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'desc' => 'required',
                'content' => 'required',
                'img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'cats' => 'required',

            ],
            [
                'required' => ':attribute không được để trống',
                'image' => 'Vui lòng chọn file ảnh',
            ],
            [
                'title' => 'Tên sản phẩm',
                'desc' => 'Mô tả sản phẩm',
                'content' => 'Nội dung sản phẩm',
                'img' => 'Ảnh đại diện sản phẩm',
                'cats' => 'Danh mục sản phẩm',
            ]
        );
        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');
        if ($request->hasFile('img')) {
            $file = $request->img;
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move('uploads', $file_name);
            $data['img'] = 'uploads/' . $file_name;
            unlink('public/' . $post->img);
        }
        $post->update($data);
        $post->categories()->sync($data['cats']);
        return redirect()->route('post.index')->with('status', 'Cập nhật sản phẩm thành công');
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
    public function delete($id)
    {
        $post = Post::find($id);
        unlink('public/' . $post->img);
        $post->delete();
        return redirect()->route('post.index')->with('status', 'Xóa bài viết thành công');
    }
    public function action(Request $request)
    {
        if (Gate::allows('post.edit')) {
            $action = $request->action;
            $checks = $request->checks;
            if (empty($checks)) {
                return redirect()->route('post.index')->with('status', 'Vui lòng chọn bài viết');
            }
            if ($action) {
                if ($action === 'public') {
                    foreach ($checks as $id => $v) {
                        $post = Post::find($id);
                        $post->update(
                            ['status' => '1']
                        );
                    }
                    return redirect()->route('post.index')->with('status', 'Cập nhật bài viết thành công');
                } elseif ($action === 'pending') {
                    foreach ($checks as $id => $v) {
                        $post = Post::find($id);
                        $post->update(
                            ['status' => '0']
                        );
                    }
                    return redirect()->route('post.index')->with('status', 'Cập nhật bài viết thành công');
                } elseif ($action === 'delete') {
                    foreach ($checks as $id => $v) {
                        $post = Post::find($id);
                        unlink('public/' . $post->img);
                        $post->delete();
                    }
                    return redirect()->route('post.index')->with('status', 'Xóa bài thành công');
                } else {
                    return redirect()->route('post.index')->with('status', 'Vui lòng chọn trạng thái');
                }
            }
        } else {
            return redirect()->route('post.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
}
