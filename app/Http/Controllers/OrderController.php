<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Distric;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Province;
use App\Models\Ward;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    function add(Request $request)
    {
        $request->validate(
            [
                'customer_name' => 'required',
                'customer_phone' => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9',
                'customer_email' => 'required|email',
                'province_id' => 'required|not_in:0',
                'district_id' => 'required|not_in:0',
                'ward_id' => 'required|not_in:0',
                'num_house' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'regex' => 'Vui lòng nhập đúng định dạng :attribute',
                'email' => 'Vui lòng nhập đúng định dạng Email',
                'not_in' => ':attribute không được để trống'
            ],
            [
                'customer_name' => 'Họ tên',
                'customer_phone' => 'Số điện thoại',
                'province_id' => 'Tỉnh/ Thành phố',
                'district_id' => 'Quận/ Huyện',
                'ward_id' => 'Phường/ Xã',
                'num_house' => 'Số nhà, tên đường'
            ]
        );
        $data = $request->all();
        $total = 0;
        foreach (Cart::content() as $row) {
            $total += $row->total;
        }
        $provine = Province::where('province_id', $data['province_id'])->first();
        $district = Distric::where('district_id', $data['district_id'])->first();
        $ward = Ward::where('wards_id', $data['ward_id'])->first();
        $address = $data['num_house'] . '-' . $ward->name . '-' . $district->name . '-' .  $provine->name;
        $data['order_code'] = 'UNI' . time();
        $data['customer_address'] = $address;
        $data['method_payment'] = $data['payment_method'];
        $data['order_total'] = $total;
        $data['qty'] = Cart::count();
        $order = Order::create($data);
        foreach (Cart::content() as $row) {
            $data_product['order_id'] = $order->id;
            $data_product['product_name'] = $row->name;
            $data_product['product_img'] =  $row->options->img;
            $data_product['product_color'] =  $row->options->color;
            $data_product['product_qty'] =  $row->qty;
            $data_product['product_price'] =  $row->price;
            OrderProduct::create($data_product);
        }
        $products = OrderProduct::where('order_id', $order->id)->get();
        $data = ['order' => $order, 'products' => $products];
        Mail::to($order->customer_email)->send(new OrderMail($data));
        Cart::destroy();
        return redirect()->route('order.success', $order->id);
    }
    function success($id)
    {
        $order = Order::find($id);
        $products = OrderProduct::where('order_id', $id)->get();
        return view('public.order_success', compact('order', 'products'));
    }
}
