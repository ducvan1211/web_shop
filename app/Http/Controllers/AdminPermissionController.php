<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminPermissionController extends Controller
{
    function add()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        // return $permissions;
        return view('admin.permission.index', compact('permissions'));
    }
    function edit($id)
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        $permission = Permission::find($id);
        return view('admin.permission.edit', compact('permissions', 'permission'));
    }
    function store(Request $request)
    {
        if (Gate::allows('permission.add')) {
            $request->validate(
                [
                    'name' => 'required|max:255',
                    'slug' => 'required',
                ],
                ['required' => ':attribute không được để trống'],
                [
                    'name' => "Tên trường",
                    'slug' => 'Slug'
                ]
            );
            $data = $request->all();
            Permission::create($data);
            return redirect()->route('permission.add')->with('status', 'Đã thêm quyền thành công');
        } else {
            return redirect()->route('permission.add')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
    function update(Request $request, $id)
    {
        if (Gate::allows('permission.edit')) {
            $permission = Permission::find($id);
            $request->validate(
                [
                    'name' => 'required|max:255',
                    'slug' => 'required',
                ],
                ['required' => ':attribute không được để trống'],
                [
                    'name' => "Tên trường",
                    'slug' => 'Slug'
                ]
            );
            $data = $request->all();
            $permission->update($data);
            return redirect()->route('permission.add')->with('status', 'Cập nhật quyền thành công');
        } else {
            return redirect()->route('permission.add')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
    function delete($id)
    {
        if (Gate::allows('permission.delete')) {
            $permission = Permission::find($id);
            $permission->delete();
            return redirect()->route('permission.add')->with('status', 'Xóa quyền thành công');
        } else {
            return redirect()->route('permission.add')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
}
