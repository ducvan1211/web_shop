<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminOrderController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'order']);
            return $next($request);
        });
    }
    function index(Request $request)
    {
        $status = $request->status;
        $actions = [
            'processing' => 'Đang xử lí',
            'transporting' => 'Đang vận chuyển',
            'success' => 'Giao hàng thành công',
            'cancel' => 'Đơn hàng hủy',
            'delete' => 'Xóa đơn hàng'
        ];
        $keyword = '';
        if ($request['s']) {
            $keyword = $request['s'];
        }
        if ($status) {
            if ($status === 'processing') {
                $orders = Order::where('order_status', 1)->where('customer_name', 'LIKE', "%$keyword%")->orderby('id', 'DESC')->get();
            } elseif ($status === 'transporting') {
                $orders = Order::where('order_status', 2)->where('customer_name', 'LIKE', "%$keyword%")->orderby('id', 'DESC')->get();
            } elseif ($status === 'success') {
                $orders = Order::where('order_status', 3)->where('customer_name', 'LIKE', "%$keyword%")->orderby('id', 'DESC')->get();
            } elseif ($status === 'cancel') {
                $orders = Order::where('order_status', 4)->where('customer_name', 'LIKE', "%$keyword%")->orderby('id', 'DESC')->get();
            }
        } else {
            $orders = Order::where('customer_name', 'LIKE', "%$keyword%")->orderby('id', 'DESC')->get();
        }
        $count['processing'] = Order::where('order_status', 1)->count();
        $count['transporting'] = Order::where('order_status', 2)->count();
        $count['all'] = Order::count();
        $count['success'] = Order::where('order_status', 3)->count();
        $count['cancel'] = Order::where('order_status', 4)->count();
        // return $orders;
        return view('admin.orders.index', compact('orders', 'count', 'actions'));
    }
    function delete($id)
    {
        if (Gate::allows('order.delete')) {
            $order = Order::find($id);
            $order->delete();
            return redirect()->route('admin.order')->with('status', 'Xóa đơn hàng thành công');
        } else {
            return redirect()->route('admin.order')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
    function detail($id)
    {
        $order = Order::find($id);

        $products = OrderProduct::where('order_id', $id)->get();
        return view('admin.orders.detail', compact('order', 'products'));
    }
    function update(Request $request, $id)
    {
        if (Gate::allows('order.edit')) {
            $order = Order::find($id);
            // return $order;
            $order->update([
                'order_status' => (int)$request->order_status,
            ]);
            return redirect()->route('admin.order.detail', $order->id)->with('status', 'Cập nhật đơn hàng thành công');
        } else {
            return redirect()->route('admin.order')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
    function action(Request $request)
    {
        if (Gate::allows('order.edit')) {
            $action = $request->action;
            $checks = $request->checks;
            if (empty($checks)) {
                return redirect()->route('admin.order')->with('status', 'Vui lòng chọn đơn hàng');
            }
            if ($action) {
                if ($action === 'processing') {
                    foreach ($checks as $id => $v) {
                        $order = Order::find($id);
                        $order->update(
                            ['order_status' => 1]
                        );
                    }
                    return redirect()->route('admin.order')->with('status', 'Cập nhật đơn hàng thành công');
                } elseif ($action === 'transporting') {
                    foreach ($checks as $id => $v) {
                        $order = Order::find($id);
                        $order->update(
                            ['order_status' => 2]
                        );
                    }
                    return redirect()->route('admin.order')->with('status', 'Cập nhật đơn hàng thành công');
                } elseif ($action === 'success') {
                    foreach ($checks as $id => $v) {
                        $order = Order::find($id);
                        $order->update(
                            ['order_status' => 3]
                        );
                    }
                    return redirect()->route('admin.order')->with('status', 'Cập nhật đơn hàng thành công');
                } elseif ($action === 'cancel') {
                    foreach ($checks as $id => $v) {
                        $order = Order::find($id);
                        $order->update(
                            ['order_status' => 4]
                        );
                    }
                    return redirect()->route('admin.order')->with('status', 'Cập nhật đơn hàng thành công');
                } elseif ($action === 'delete') {
                    foreach ($checks as $id => $v) {
                        $order = Order::find($id);
                        $order->delete();
                    }
                    return redirect()->route('admin.order')->with('status', 'Xóa đơn hàng thành công');
                } else {
                    return redirect()->route('admin.order')->with('status', 'Vui lòng chọn trạng thái');
                }
            }
        } else {
            return redirect()->route('admin.order')->with('danger', 'Bạn không được cấp quyền thực hiện tác vụ này');
        }
    }
}
