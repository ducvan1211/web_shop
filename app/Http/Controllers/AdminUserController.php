<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'user']);
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        $keyword = '';
        $actions = ['delete' => 'Vô hiệu hóa', 'permanently' => 'Xóa vĩnh viễn'];
        $status = $request['status'];
        if ($status === 'trash') {
            $users = User::onlyTrashed()->get();
            // $users->appends(['status' => 'trash']);
            $actions = ['restore' => 'Khôi phục', 'permanently' => 'Xóa vĩnh viễn'];
        } else {
            if ($request['s']) {
                $keyword = $request['s'];
            }
            $users = User::where('name', 'LIKE', "%$keyword%")->get();
        }

        $count['active'] = User::count();
        $count['trash'] = User::onlyTrashed()->count();
        return view('admin.users.index', compact('users', 'count', 'actions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::allows('user.add')) {
            $request->validate(
                [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                    'roles' => 'required',
                ],
                [
                    'required' => ':attribute không được bỏ trống',
                    'max:255' => ':attribute tối đa 255 kí tự',
                    'min:8' => ':attribute tối thiểu 8 kí tự',
                    'email' => 'Vui lòng nhập đúng định dạng email',
                    'unique' => 'Dữ liệu đã tồn tại trong hệ thống',
                    'confirmed' => 'Xác nhận mật khẩu không chính xác'
                ],
                [
                    'name' => 'Họ và tên',
                    'email' => 'Địa chỉ Email',
                    'password' => 'Mật khẩu ',
                    'roles' => 'Danh sách vai trò'
                ]
            );
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            $user->roles()->attach($data['roles']);
            return redirect()->route('user.index')->with('status', 'Thêm dữ liệu thành công');
        } else {
            return redirect()->route('user.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
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
        $roles = Role::all();
        $user = User::find($id);
        $user_roles = $user->roles;
        return view('admin.users.edit', compact('user', 'roles', 'user_roles'));
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
        if (Gate::allows('user.edit')) {
            $request->validate(
                [
                    'name' => ['required', 'string', 'max:255'],
                    'roles' => 'required',
                    // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    // 'password' => ['required', 'string', 'min:8', 'confirmed'],
                ],
                [
                    'required' => ':attribute không được bỏ trống',
                    'max:255' => ':attribute tối đa 255 kí tự',
                    'min:8' => ':attribute tối thiểu 8 kí tự',
                    'email' => 'Vui lòng nhập đúng định dạng email',
                    'unique' => 'Dữ liệu đã tồn tại trong hệ thống',
                    'confirmed' => 'Xác nhận mật khẩu không chính xác'
                ],
                [
                    'name' => 'Họ và tên',
                    'email' => 'Địa chỉ Email',
                    'password' => 'Mật khẩu ',
                    'roles' => 'Danh sách vai trò'
                ]
            );
            $data = $request->all();
            // return $data;
            // $data['password'] = Hash::make($data['password']);
            $user = User::find($id);
            $user->update($data);
            $user->roles()->sync($data['roles']);
            return redirect()->route('user.index')->with('status', 'Cập nhật tài khoản thành công');
        } else {
            return redirect()->route('user.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
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
        // if (Auth::id() === $id) {
        //     return redirect()->route('user.index')->with('status', 'Bạn không thể xóa chính bạn');
        // } else {
        //     $user = User::find($id);
        //     $user->delete();
        //     return redirect()->route('user.index')->with('status', 'Vô hiệu hóa tài khoản thành công');
        // }
    }
    public function action(Request $request)
    {
        if (Gate::allows('user.delete')) {
            $action = $request['action'];
            $checks = $request['checks'];
            if (empty($checks)) {
                return redirect()->route('user.index')->with('status', 'Vui lòng chọn tài khoản để thực hiện hành động');
            }
            if ($action === 'delete') {
                foreach ($checks as $key => $value) {
                    $user = User::find($value);
                    $user->delete();
                }
                return redirect()->route('user.index')->with('status', 'Vô hiệu hóa tài khoản thành công');
            } elseif ($action === 'restore') {
                foreach ($checks as $key => $value) {
                    User::onlyTrashed()->where('id', $value)->restore();
                }
                return redirect()->route('user.index')->with('status', 'Khôi phục tài khoản thành công');
            } elseif ($action === 'permanently') {
                foreach ($checks as $key => $value) {
                    $user = User::find($value);
                    $user->forceDelete();
                }
                return redirect()->route('user.index')->with('status', 'Xóa vĩnh viễn tài khoản thành công');
            } else {
                return redirect()->route('user.index')->with('status', 'Vui lòng chọn hành động');
            }
        } else {
            return redirect()->route('user.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
    public function force_delete($id)
    {
        if (Gate::allows('user.delete')) {
            User::onlyTrashed()->where('id', $id)->forceDelete();
            return redirect()->route('user.index')->with('status', 'Xóa vĩnh viễn tài khoản thành công');
        } else {
            return redirect()->route('user.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
    public function delete($id)
    {
        if (Gate::allows('user.delete')) {
            if (Auth::id() === $id) {
                return redirect()->route('user.index')->with('status', 'Bạn không thể xóa chính bạn');
            } else {
                $user = User::find($id);
                $user->delete();
                return redirect()->route('user.index')->with('status', 'Vô hiệu hóa tài khoản thành công');
            }
        } else {
            return redirect()->route('user.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
    function restore($id)
    {
        if (Gate::allows('user.delete')) {
            User::onlyTrashed()->where('id', $id)->restore();
            return redirect()->route('user.index')->with('status', 'Khôi phục tài khoản thành công');
        } else {
            return redirect()->route('user.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
}
