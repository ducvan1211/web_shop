<?php

namespace App\Http\Controllers;

// include '../web_shop/helper_func/function.php';

use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryPost;
use App\Models\Color;
use App\Models\ConfigurationDetail;
use App\Models\ConfigurationType;
use App\Models\Product;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AjaxController extends Controller
{
    public function edit_cat_product(Request $request)
    {
        $data = $request->all();
        $cats_public = Category::where('status', '1')->whereNotIn('id', [$data['id']])->get();
        $options = '';
        $cat_update = Category::find($data['id']);

        foreach ($cats_public as $cat) {
            $check_cat = '';
            if ($cat->id == $cat_update->parent_id) {
                $check_cat = 'selected';
            }
            // $check_cat = $cat->id === $cat_update->id ? 'selected' : '';
            $options .= '<option ' . $check_cat . '  value="' . $cat->id . '">' . $cat->title . '</option>';
        }
        // echo $options;
        $check_0 = '';
        $check_1 = '';
        if ($cat_update['status'] === '0') {
            $check_0 = 'checked';
        } else {
            $check_1 = 'checked';
        }
        $feature_0 = '';
        $feature_1 = '';
        if ($cat_update['cat_feature'] === '0') {
            $feature_0 = 'checked';
        } else {
            $feature_1 = 'checked';
        }
        // $check_0 = $cat_update['status'] === '0' ? 'checked' : '';
        $html = '
                        <div class="form-group">
                            <label for="title_update">Tên danh mục</label>
                            <input class="form-control titl_update" type="text" data-id="' . $cat_update->id . '" name="title" id="title_update" value="' . $cat_update->title . '">
                            <span id="err_title_update" class="form-text text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="icon_update">Icon</label>
                            <input class="form-control" type="text" name="icon" id="icon_update" value="' . $cat_update->icon . '">
                        </div>
                        <div class="form-group">
                            <label for="">Danh mục cha</label>
                            <select class="form-control" name="parent_id">
                                <option value="0">Chọn danh mục</option>
                                ' . $options . '
                            </select>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="">Trạng thái</label>
                                <div class="form-check">
                                    <input ' .  $check_0 . ' class="form-check-input" type="radio" name="status" id=""
                                        value="0">
                                    <label class="form-check-label" for="">
                                        Chờ duyệt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input ' .  $check_1 . ' class="form-check-input" type="radio" name="status" id=""
                                        value="1" >
                                    <label class="form-check-label" for="">
                                        Công khai
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label for="">Nổi bật</label>
                                <div class="form-check">
                                    <input ' .  $feature_1 . '  class="form-check-input" type="radio" name="cat_feature" id=""
                                        value="1">
                                    <label class="form-check-label" for="">
                                        Có
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input ' .  $feature_0 . '  class="form-check-input" type="radio" name="cat_feature" id=""
                                        value="0">
                                    <label class="form-check-label" for="">
                                        Không
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="update" id="btn_update_cat" class="btn btn-primary w-100">Cập nhật</button>
                    
        ';
        echo $html;
    }
    function update_cat_product(Request $request)
    {
        $request->validate(
            [
                // 'img' => 'required|mimes:jpg,png|max:2048',
                'title' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'unique' => 'Dữ liệu đã tồn tại trong hệ thống'
            ],
            [
                'title' => 'Tên danh mục',
            ]
        );
        $data = $request->all();
        $cat = Category::find($data['id']);
        $data['parent_id'] = (int) $data['parent_id'];
        $data['slug'] =  Str::slug($data['title'], '-');
        $cat->update($data);
        return response()->json($data);
    }


    function delele_img(Request $request)
    {
        $id = $request->id;
        // $request->session()->flush();
        $request->session()->flash($id, $id);

        if ($request->session()->has('list_id')) {
            $request->session()->reflash();
            $request->session()->push('list_id', $id);
        } else {
            $request->session()->flash('list_id', [$id]);
        }
        return response()->json($id);
    }
    public function edit_brand(Request $request)
    {
        $data = $request->all();
        $cats = Arr::data_tree(Category::where('status', '1')->get());
        $brand = Brand::with('categories')->where('id', $data['id'])->first();
        $check_0 = '';
        $check_1 = '';
        if ($brand['status'] === '0') {
            $check_0 = 'checked';
        } else {
            $check_1 = 'checked';
        }
        $html_cats = '';
        foreach ($cats as $cat) {
            foreach ($brand->categories as $item) {
                $check_cat = $item->id === $cat->id ? 'checked' : '';
                if ($check_cat) {
                    break;
                }
            }
            $html_cats .= '
            <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="cat_edit' . $cat->id . '"
                     value="' . $cat->id . '" name="cats[' . $cat->id . ']" ' . $check_cat . '>

                    <label class="form-check-label" for="cat_edit' . $cat->id . '">' . $cat->title . '</label>
            </div>
            ';
        }
        $html = '
                        <form id="fileUpload" data-id="' . $brand->id . '">
                             <div class="form-group">
                                <label for="b_title_edit">Tên thương hiệu</label>
                                <input class="form-control" type="text" name="b_title" data-id="' . $brand->id . '" value="' . $brand->b_title . '" id="b_title_edit">
                                <span id="err_title" class="form-text text-danger"></span>

                            </div>
                            <div class="form-group">
                                <label for="img_edit">Hình ảnh</label>
                                <input type="file" id="img_edit" name="img" class="form-control">
                                <span id="err_img" class="form-text text-danger"></span>
                                
                                <img class="mt-2" style="width:100px;height:70px;object-fit:contain" src="http://127.0.0.1:8000/' . $brand->img . '" alt="">
                            </div>
                            <div class="form-group">
                                <div>
                                    <label for="">Thương hiệu thuộc danh mục</label>
                                </div>
                           ' . $html_cats . '
                           
                            </div>
                            <div class="form-group ">
                                <label for="">Trạng thái</label>
                                <div class="form-check">
                                    <input ' . $check_0 . ' class="form-check-input" type="radio" name="status" id="status1_edit"
                                        value="0">
                                    <label class="form-check-label" for="status1_edit">
                                        Chờ duyệt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input ' . $check_1 . ' class="form-check-input" type="radio" name="status" id="exampleRadios2_edit"
                                        value="1" >
                                    <label class="form-check-label" for="exampleRadios2_edit">
                                        Công khai
                                    </label>
                                </div>
                            </div>
                            <button type="submit" id="btn_fileUpload" class="btn btn-primary w-100">Cập nhật</button>
                        </form>

        ';
        echo $html;
    }
    function update_brand(Request $request)
    {
        $request->validate(
            [
                // 'img' => 'required|mimes:jpg,png|max:2048',
                'b_title' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'unique' => 'Dữ liệu đã tồn tại trong hệ thống'
            ],
            [
                'b_title' => 'Tên thương hiệu',
            ]
        );
        $data = $request->all();
        $id = (int)$request->id;
        $brand = Brand::find($id);

        if ($request->img) {
            $fileName = time() . '_' . $request->img->getClientOriginalName();
            $request->img->move('uploads', $fileName);
            unlink('public/' . $brand->img);
            $data['img'] = 'uploads/' . $fileName;
        }

        $data['b_title'] = $request->b_title;
        $data['status'] = $request->status;
        $brand->update($data);
        $brand->categories()->sync($data['cats']);
        return response()->json($data);
    }
    public function edit_color(Request $request)
    {
        $data = $request->all();
        $color = Color::find($data['id']);
        $check_0 = '';
        $check_1 = '';
        if ($color->status === '0') {
            $check_0 = 'checked';
        } else {
            $check_1 = 'checked';
        }
        $html = '
                <div class="form-group">
                    <label for="title_update">Màu sắc</label>
                    <input class="form-control" type="text" name="title" data-id="' . $color->id . '" id="title_update" value="' . $color->title . '">
                    <span id="err_title" class="form-text text-danger"></span>
    
                </div>
                <div class="form-group">
                    <label for="">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="color_update_1"
                            value="0" ' . $check_0 . '>
                        <label class="form-check-label" for="color_update_1">Chờ duyệt</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="color_update_2"
                            value="1" ' . $check_1 . '>
                        <label class="form-check-label" for="color_update_2">Công khai</label>
                    </div>
                </div>
                <button type="submit" name="btn_update" class="btn btn-primary">Cập nhật</button>

        ';
        echo $html;
    }
    function update_color(Request $request)
    {
        $request->validate(
            [
                'title' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'unique' => 'Dữ liệu đã tồn tại trong hệ thống'
            ],
            [
                'title' => 'Màu sắc',
            ]
        );
        $data = $request->all();
        $id = (int)$request->id;
        $color = Color::find($id);
        $color->update($data);
        return response()->json($data);
    }
    // UPDATE TITLE CONFIGURATION TYPE
    function update_title_type(Request $request)
    {
        $data = $request->all();
        $type = ConfigurationType::find($data['id']);
        $type->update(
            ['title' => $data['value']]
        );
        echo "Success";
    }
    function update_status_type(Request $request)
    {
        $data = $request->all();
        $type = ConfigurationType::find($data['id']);
        $type->update(
            ['status' => $data['status']]
        );
        echo "Success";
    }
    function update_title_detail(Request $request)
    {
        $data = $request->all();
        $type = ConfigurationDetail::find($data['id']);
        $type->update(
            ['title' => $data['value']]
        );
        echo "Success";
    }
    function update_status_detail(Request $request)
    {
        $data = $request->all();
        $detail = ConfigurationDetail::find($data['id']);
        $detail->update(
            ['status' => $data['status']]
        );
        echo "Success";
    }
    function update_type_id_detail(Request $request)
    {
        $data = $request->all();
        $detail = ConfigurationDetail::find($data['id']);
        $detail->update(
            ['type_id' => (int) $data['type_id']]
        );
        echo "Success";
    }
    function product_config(Request $request)
    {
        $data = $request->all();
        $config_details = ConfigurationDetail::where('type_id', $data['type_id'])->where('status', '1')->orderby('title')->get();
        $html = '';

        if (empty($config_details)) {
            $html = '';
        } else {
            foreach ($config_details as $key => $value) {
                $html .= '
            <div class="form-group">
                <label for="' . $key . '">' . $value->title . '</label>
                <input class="form-control" type="text" name="config[' . $value->title . ']" id="' . $key . '">
            </div>
        ';
            }
        }

        echo $html;
    }
    function edit_cat_post(Request $request)
    {
        $id = $request->id;
        $cat_update = CategoryPost::find($id);
        $cat_publics = CategoryPost::where('status', '1')->get();
        $options = '';
        foreach ($cat_publics as $cat) {
            $check_cat = '';
            if ($cat->id === $cat_update->parent_id) {
                $check_cat = 'selected';
            }
            // $check_cat = $cat->id === $cat_update->id ? 'selected' : '';
            $options .= '<option ' . $check_cat . '  value="' . $cat->id . '">' . $cat->title . '</option>';
        }
        $check_0 = '';
        $check_1 = '';
        if ($cat_update->status === '0') {
            $check_0 = 'checked';
        } else {
            $check_1 = 'checked';
        }
        $html = '
                <div class="form-group">
                    <label for="title_update">Tên danh mục</label>
                    <input class="form-control" type="text" name="title" value="' . $cat_update->title . '" id="title_update" data-id="' . $cat_update->id . '">
                    <span id="err_title" class="form-text text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="parent">Danh mục cha</label>
                    <select class="form-control" id="parent" name="parent_id">
                        <option value="0">Chọn danh mục</option>
                       ' . $options . '
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status"          id="status_edit_0" value="0" ' . $check_0 . '>
                        <label class="form-check-label" for="status_edit_0">
                            Chờ duyệt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status_edit_1" value="1" ' . $check_1 . '>
                        <label class="form-check-label" for="status_edit_1">
                         Công khai
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>       
        
        ';
        echo $html;
    }
    function update_cat_post(Request $request)
    {
        $request->validate(
            [
                // 'img' => 'required|mimes:jpg,png|max:2048',
                'title' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'unique' => 'Dữ liệu đã tồn tại trong hệ thống'
            ],
            [
                'title' => 'Tên danh mục bài viết',
            ]
        );
        $data = $request->all();
        $id = (int)$request->id;
        $cat = CategoryPost::find($id);
        $data['title'] = $request->title;
        $data['slug'] = Str::slug($data['title'], '-');
        $data['status'] = $request->status;
        $data['parent_id'] = (int)$request->parent_id;
        $cat->update($data);
        return response()->json($data);
    }
    function product__search(Request $request)
    {
        $data = $request->value;
        $products = Product::where('status', '1')->where('title', 'LIKE', "%$data%")->take(10)->get();
        $html = '';
        if ($products->count() > 0) {
            foreach ($products as $product) {
                $html .= '
            <li>
                <a href="' . route('product.detail', $product->slug) . '" class="card__img">
                    <img src="' . asset($product->img) . '"
                    alt="">
                </a>
                <div class="card__info">
                    <a href="' . route('product.detail', $product->slug) . '" class="card__name">' . $product->title . '</a>
                    <p class="card__price">' . number_format($product->price, 0, '', '.') . '₫</p>
                </div>
            </li>
            ';
            }
        } else {
            $html = '<li>Không tìm thấy sản phẩm nào</li>';
        }

        echo $html;
    }
}
