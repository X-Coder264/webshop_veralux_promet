<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where('highlighted', '=', true)->paginate(4);

        return view('welcome', ['products' => $products]);
    }

    public function highlightedProducts(Request $request)
    {
        $products = Product::where('highlighted', '=', true)->paginate(4);
        $html = '';

        foreach ($products as $product) {
            $link = route('product.show', $product->slug, false);
            $image_link = '/product_images/' . $product->slug . '/' . $product->mainImage->path;
            $html .= '<div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6 cursor-pointer" onclick="window.location=' . $link . ';" style="height:312px;">
                        <div class="product">
                            <div class="image">
                                 <a href="' . $link . '">
                                    <img src="' . $image_link . '" alt="img" class="img-responsive">
                                </a>
                                <div class="promotion">
                                    <span class="new-product">Istaknuti proizvod</span>
                                </div>
                            </div>
                            <div class="description">
                                <h4>
                                    <a href="' . $link . '">' . $product->name . '</a>
                                </h4>
                            </div>
                        </div>
                    </div>';
        }

        return $html;
    }
}
