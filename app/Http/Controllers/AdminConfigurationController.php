<?php

namespace App\Http\Controllers;

use App\Models\ConfigurationDetail;
use App\Models\ConfigurationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminConfigurationController extends Controller
{
    public function index()
    {
        $types = ConfigurationType::all();
        $details = ConfigurationDetail::orderby('type_id')->get();
        $is_disable = true;
        if (Gate::allows('product.edit') || Gate::allows('product.add')) {
            $is_disable = false;
        }

        return view('admin.configuration.index', compact('types', 'details', 'is_disable'));
    }
    public function type_store(Request $request)
    {
        if (Gate::allows('product.edit') || Gate::allows('product.add')) {
            $request->validate(
                [
                    'title' => 'required|unique:configuration_types',
                ],
                [
                    'required' => 'Vui lòng nhập loại cấu hình',
                    'unique' => 'Dữ liệu đã tồng tại trong hệ thống'
                ]
            );
            $data = $request->all();
            ConfigurationType::create($data);
            return redirect()->route('configuration.index')->with('status', 'Thêm dữ liệu thành công');
        } else {
            return redirect()->route('configuration.index')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
    public function detail_store(Request $request)
    {
        if (Gate::allows('product.edit') || Gate::allows('product.add')) {
            $request->validate(
                [
                    'title' => 'required',
                ],
                [
                    'required' => 'Vui lòng nhập loại cấu hình',
                    'unique' => 'Dữ liệu đã tồng tại trong hệ thống'
                ]
            );
            $data = $request->all();
            $data['type_id'] = (int)$data['type_id'];

            ConfigurationDetail::create($data);
            return redirect()->route('configuration.index')->with('status_detail', 'Thêm dữ liệu thành công');
        } else {
            return redirect()->route('configuration.index')->with('danger_detail', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
    public function type_destroy($id)
    {
        if (Gate::allows('product.edit') || Gate::allows('product.add')) {
            $type = ConfigurationType::find($id);
            $type->delete();
            return redirect()->route('configuration.index')->with('status', 'Xóa dữ liệu thành công');
        } else {
            return redirect()->route('configuration.index')->with('danger_detail', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
    public function detail_destroy($id)
    {
        if (Gate::allows('product.edit') || Gate::allows('product.add')) {
            $detail = ConfigurationDetail::find($id);
            $detail->delete();
            return redirect()->route('configuration.index')->with('status_detail', 'Xóa dữ liệu thành công');
        } else {
            return redirect()->route('configuration.index')->with('danger_detail', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
}
