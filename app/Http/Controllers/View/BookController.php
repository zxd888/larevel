<?php
namespace App\Http\Controllers\View;

use App\Entity\Category;
use App\Entity\PdtContent;
use App\Entity\PdtImages;
use App\Entity\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;


class BookController extends Controller {
    public function toCategory() {
        $categorys = Category::whereNull('parent_id')->get();
        Log::info('进入书籍类别');
        return View('category')->with('categorys', $categorys);
    }
    public function toProduct($category_id) {
        $products = Product::where('category_id', $category_id)->get();
        return view('product')->with('products', $products);
    }
    public function toPdtContent(Request $request, $product_id) {
        $product = Product::find($product_id);
        $pdt_content = PdtContent::where('product_id', $product_id)->first();
        $pdt_images = PdtImages::where('product_id', $product_id)->get();

        //通过cookie获取购物车数量
        $bk_cart = $request->cookie('bk_cart');
        $bk_cart_arr = ($bk_cart != null ? explode(',', $bk_cart) : array());
        $count = 0;
        foreach ($bk_cart_arr as $value) {
            $index = strpos($value, ':');
            if (substr($value, 0, $index) == $product_id) {
                $count = (int) substr($value, $index + 1);
                break;
            }
        }

        return view('pdt_content')->with('product', $product)
                                   ->with('pdt_images', $pdt_images)
                                   ->with('count', $count)
                                   ->with('ptd_content', $pdt_content);
    }
}