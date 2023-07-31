<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryPost;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// include '../web_shop/helper_func/function.php';

class IndexController extends Controller
{
    public function home()
    {
        $new_products = Product::where('status', '1')->orderBy(DB::raw('RAND()'))->take(8)->get();
        $mobile_cat = Category::find(1);
        $mobiles = $mobile_cat->products()->where('status', '1')->orderBy(DB::raw('RAND()'))->take(10)->get();
        $laptop_cat = Category::find(2);
        $laptops = $laptop_cat->products()->where('status', '1')->orderBy(DB::raw('RAND()'))->take(10)->get();
        $smartwatch_cat = Category::find(4);
        $watchs = $smartwatch_cat->products()->where('status', '1')->orderBy(DB::raw('RAND()'))->take(10)->get();
        $headphone_cat = Category::find(10);
        $headphones = $headphone_cat->products()->where('status', '1')->orderBy(DB::raw('RAND()'))->take(10)->get();
        $tv_cat = Category::find(15);
        $tvs = $tv_cat->products()->where('status', '1')->orderBy(DB::raw('RAND()'))->take(10)->get();
        $sliders = Slider::where('status', 1)->where('type_img', 'slider')->get();
        $banners = Slider::where('status', 1)->where('type_img', 'banner')->orderby('id', 'DESC')->take(3)->get();
        return view('home', compact('mobiles', 'laptops', 'new_products', 'watchs', 'tvs', 'headphones', 'sliders', 'banners'));
    }
    public function category_product(Request $request)
    {
        $soft = $request->soft;
        $slug = $request->slug;
        $min_price = 0;
        $max_price = 100000000;
        $filter = $request->filter;

        $cat = Category::where('slug', $slug)->where('status', '1')->first();
        if ($filter) {
            if ($filter === 'duoi1tr') {
                $min_price = 0;
                $max_price = 1000000;
            } elseif ($filter === 'tu1den5tr') {
                $min_price = 1000000;
                $max_price = 5000000;
            } elseif ($filter === 'tu5den10tr') {
                $min_price = 5000000;
                $max_price = 10000000;
            } elseif ($filter === 'tu10den20tr') {
                $min_price = 10000000;
                $max_price = 20000000;
            } elseif ($filter === 'tren20tr') {
                $min_price = 20000000;
            }
        }
        if ($cat->parent_id !== 0) {
            $cat['cat_parent'] = Category::where('id', $cat->parent_id)->where('status', '1')->first();
        }
        $brands = $cat->brands()->where('status', '1')->get();
        if ($request->brand) {
            $brand_filter = Brand::where('slug', $request->brand)->first();
            if ($soft) {
                // return $soft;
                if ($soft === 'asc') {
                    $products = $cat->products()->where('status', '1')->where('brand_id', $brand_filter->id)->whereBetween('price', [$min_price, $max_price])->orderby('title')->get();
                } elseif ($soft === 'desc') {
                    $products = $cat->products()->where('status', '1')->where('brand_id', $brand_filter->id)->whereBetween('price', [$min_price, $max_price])->orderby('title', 'DESC')->get();
                } elseif ($soft === 'tangdan') {
                    $products = $cat->products()->where('status', '1')->where('brand_id', $brand_filter->id)->whereBetween('price', [$min_price, $max_price])->orderby('price', 'ASC')->get();
                } elseif ($soft === 'giamdan') {
                    $products = $cat->products()->where('status', '1')->where('brand_id', $brand_filter->id)->whereBetween('price', [$min_price, $max_price])->orderby('price', 'DESC')->get();
                } else {
                    $products = $cat->products()->where('status', '1')->where('brand_id', $brand_filter->id)->whereBetween('price', [$min_price, $max_price])->get();
                }
            } else {
                $products = $cat->products()->where('status', '1')->where('brand_id', $brand_filter->id)->whereBetween('price', [$min_price, $max_price])->get();
            }
        } else {
            if ($soft) {
                // return $soft;

                if ($soft === 'asc') {
                    $products = $cat->products()->where('status', '1')->whereBetween('price', [$min_price, $max_price])->orderby('title')->get();
                } elseif ($soft === 'desc') {
                    $products = $cat->products()->where('status', '1')->whereBetween('price', [$min_price, $max_price])->orderby('title', 'DESC')->get();
                } elseif ($soft === 'tangdan') {
                    $products = $cat->products()->where('status', '1')->whereBetween('price', [$min_price, $max_price])->orderby('price', 'ASC')->get();
                } elseif ($soft === 'giamdan') {
                    $products = $cat->products()->where('status', '1')->whereBetween('price', [$min_price, $max_price])->orderby('price', 'DESC')->get();
                } else {
                    $products = $cat->products()->where('status', '1')->whereBetween('price', [$min_price, $max_price])->get();
                }
            } else {
                $products = $cat->products()->where('status', '1')->whereBetween('price', [$min_price, $max_price])->get();
            }
            $brand_filter = null;
        }
        return view('public.category_product', compact('products', 'cat', 'brands', 'brand_filter'));
    }
    public function detail($slug)
    {
        $product = Product::with('images', 'colors')->where('slug', $slug)->where('status', '1')->first();
        $images = $product->images()->orderby('id', 'DESC')->get();
        $cat = $product->categories()->where('parent_id', 0)->first();
        $product_list = $cat->products()->where('status', '1')->orderBy(DB::raw('RAND()'))->take(10)->get();
        return view('public.product_detail', compact('product', 'cat', 'product_list', 'images'));
    }
    function product_search(Request $request)
    {
        $data = $request->all();
        if ($data['s']) {
            $search_value = $data['s'];
            $products = Product::where('status', '1')->where('title', "LIKE", "%$search_value%")->get();
            return view('public.product_search', compact('products', 'search_value'));
        } else {
            return redirect()->back();
        }
    }
    function post()
    {
        $hot_posts = Post::with('user')->where('status', '1')->orderby('id', 'DESC')->take(3)->get();
        $new_posts = Post::with('user')->where('status', '1')->orderby('id', 'DESC')->take(6)->get();
        foreach ($new_posts as $post) {
            $post['desc'] = Str::limit($post['desc'], 130, '...');
        }
        $congnghe = CategoryPost::find(1);
        $congnghe_posts = $congnghe->posts()->with('user')->where('status', '1')->orderby('id', 'DESC')->take(4)->get();
        foreach ($congnghe_posts as $post) {
            $post['desc'] = Str::limit($post['desc'], 130, '...');
        }
        $game = CategoryPost::find(2);
        $game_posts = $game->posts()->with('user')->where('status', '1')->orderby('id', 'DESC')->take(4)->get();
        foreach ($game_posts as $post) {
            $post['desc'] = Str::limit($post['desc'], 130, '...');
        }
        $thuthuat = CategoryPost::find(11);
        $thuthuat_posts = $thuthuat->posts()->with('user')->where('status', '1')->orderby('id', 'DESC')->take(4)->get();
        foreach ($thuthuat_posts as $post) {
            $post['desc'] = Str::limit($post['desc'], 130, '...');
        }
        $danhgia = CategoryPost::find(13);
        $danhgia_posts = $danhgia->posts()->with('user')->where('status', '1')->orderby('id', 'DESC')->take(4)->get();
        foreach ($danhgia_posts as $post) {
            $post['desc'] = Str::limit($post['desc'], 130, '...');
        }
        return view('public.post', compact('hot_posts', 'new_posts', 'congnghe_posts', 'game_posts', 'thuthuat_posts', 'danhgia_posts'));
    }
    function category_post($slug)
    {
        $hot_posts = Post::with('user')->where('status', '1')->orderby('id', 'DESC')->take(3)->get();
        $cat = CategoryPost::where('slug', $slug)->first();
        $posts = $cat->posts()->with('user')->where('status', '1')->orderby('id', 'DESC')->take(8)->get();
        foreach ($posts as $post) {
            $post['desc'] = Str::limit($post['desc'], 130, '...');
        }
        return view('public.category_post', compact('posts', 'cat', 'hot_posts'));
    }
    function post_search(Request $request)
    {
        $hot_posts = Post::with('user')->where('status', '1')->orderby('id', 'DESC')->take(3)->get();
        $posts = Post::with('user')->where('status', '1')->where('title', 'LIKE', "%$request->s%")->orderby('id', 'DESC')->get();
        foreach ($posts as $post) {
            $post['desc'] = Str::limit($post['desc'], 130, '...');
        }
        return view('public.post_search', compact('posts', 'hot_posts'));
    }
    function detail_post($slug)
    {
        $post = Post::with('user')->where('slug', $slug)->where('status', '1')->first();
        $new_posts = Post::with('user')->where('status', '1')->orderby('id', 'DESC')->take(5)->get();
        return view('public.post_detail', compact('post', 'new_posts'));
    }
    function page($slug)
    {
        $page = Page::where('slug', $slug)->first();
        return view('public.page', compact('page'));
    }
}
