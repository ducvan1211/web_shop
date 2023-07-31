<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Distric;
use App\Models\Product;
use App\Models\Province;
use App\Models\Ward;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    function index()
    {
        return view('public.cart');
    }
    function add(Request $request)
    {
        // Cart::destroy();
        $data = $request->all();
        $product_id = $data['product_id'];
        $product = Product::find($product_id);
        $color_id = $data['color_id'];
        $color = Color::find($color_id);
        Cart::add(
            [
                'id' => $product_id . '_' . $color_id,
                'name' => $product->title,
                'qty' => 1,
                'price' => $product->price,
                'options' => [
                    'color' => $color->title,
                    'img' => $product->img,
                ]
            ]
        );
        echo Cart::count();
    }
    function remove($rowId)
    {
        Cart::remove($rowId);
        return redirect()->back();
    }
    function update(Request $request)
    {
        $data = $request->all();
        Cart::update($data['product_id'], $data['qty']);
        foreach (Cart::content() as $row) {
            $respon['cart'][$row->rowId] = number_format($row->total, 0, '', '.') . 'đ';
        }
        $respon['total'] = Cart::total();
        $respon['count'] = Cart::count();
        return response()->json($respon);
    }
    function destroy()
    {
        Cart::destroy();
        return redirect()->back();
    }
    function pay()
    {
        $provinces = Province::orderby('name')->get();
        return view('public.cart_pay', compact('provinces'));
    }
    function load_distric(Request $request)
    {
        $province_id = (int) $request->province_id;
        $districts = Distric::where('province_id', $province_id)->get();
        // return response()->json($districs);
        $html = '
        <option value="0">Chọn Quận/ Huyện</option>
        ';
        foreach ($districts as $district) {
            $html .= '
            <option value="' . $district->district_id . '">
            ' . $district->name . '
            </option>
            ';
        }
        echo $html;
    }
    function load_ward(Request $request)
    {
        $district_id = (int) $request->district_id;
        $wards = Ward::where('district_id', $district_id)->get();
        // return response()->json($districs);
        $html = '
        <option value="0">Chọn Phường/ Xã</option>
        ';
        foreach ($wards as $ward) {
            $html .= '
            <option value="' . $ward->wards_id . '">
            ' . $ward->name . '
            </option>
            ';
        }
        echo $html;
    }
}
