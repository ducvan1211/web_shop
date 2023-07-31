<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\CategoryPost;
use App\Models\Page;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        $cat_products = Category::where('status', '1')->get();
        foreach ($cat_products as $cat) {
            if ((int)$cat->parent_id === 0) {
                foreach ($cat_products as $item) {
                    if ($item->parent_id === $cat->id) {
                        $cat['has_child'] = true;
                    }
                }
            }
        }
        $cat_posts = CategoryPost::where('status', '1')->get();
        foreach ($cat_posts as $cat) {
            if ((int)$cat->parent_id === 0) {
                foreach ($cat_posts as $item) {
                    if ($item->parent_id === $cat->id) {
                        $cat['has_child'] = true;
                    }
                }
            }
        }
        $pages = Page::where('status', '1')->get();
        View::share([
            'cat_products' => $cat_products,
            'cat_posts' => $cat_posts,
            'pages' => $pages,
        ]);
    }
}
