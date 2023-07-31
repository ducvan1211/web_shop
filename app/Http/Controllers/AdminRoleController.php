<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'role']);
            return $next($request);
        });
    }
    public function index()
    {
        // return Gate::allows('role.view');
        if (Gate::allows('role.view')) {
            $roles = Role::all();
            return view('admin.roles.index', compact('roles'));
        } else {
            abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::allows('role.add')) {
            $request->validate(
                [
                    'name' => 'required|max:255',
                    'description' => 'required',
                    'permission_id' => 'required'
                ],
                ['required' => ':attribute không được để trống'],
                [
                    'name' => "Tên vai trò",
                    'description' => 'Mô tả vai trò',
                    'permission_id' => 'Danh sách quyền'
                ]
            );
            $data = $request->all();
            $role = Role::create($data);
            $role->permissions()->attach($request->input('permission_id'));
            return redirect()->route('role.index')->with('status', 'Thêm vai trò thành công');
        } else {
            return redirect()->route('role.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
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
        $role = Role::find($id);
        $role_permissions = $role->permissions;
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        return view('admin.roles.edit', compact('permissions', 'role', 'role_permissions'));
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
        if (Gate::allows('role.edit')) {
            $role = Role::find($id);
            $request->validate(
                [
                    'name' => 'required|max:255',
                    'description' => 'required',
                    'permission_id' => 'required'
                ],
                ['required' => ':attribute không được để trống'],
                [
                    'name' => "Tên vai trò",
                    'description' => 'Mô tả vai trò',
                    'permission_id' => 'Danh sách quyền'
                ]
            );
            $data = $request->all();
            $role->update($data);
            $role->permissions()->sync($data['permission_id']);
            return redirect()->route('role.index')->with('status', 'Cập nhật vai trò thành công');
        } else {
            return redirect()->route('role.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
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
    public function delete($id)
    {
        if (Gate::allows('role.delete')) {
            $role = Role::find($id);
            $role->delete();
            return redirect()->route('role.index')->with('status', 'Xóa vai trò thành công');
        } else {
            return redirect()->route('role.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
}
