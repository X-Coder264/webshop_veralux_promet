<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        // show the cart and make sure that the products added to the cookie still exists in the DB
        // if they were deleted in the meantime, update and return the updated cookie
        $products_with_quantity = unserialize(Cookie::get('cart_product_IDs'));
        $DatabaseDeletedProduct = false;
        if (false !== $products_with_quantity) {
            $product_IDs = collect($products_with_quantity)->pluck('product_id');
            $product_ids_ordered = implode(',', $product_IDs->toArray());
            $products = Product::whereIn('id', $product_IDs)->orderByRaw(
                DB::raw("FIELD(id, $product_ids_ordered)")
            )->get();
            $count = count($products_with_quantity);
            if (0 !== $products->count()) {
                for ($i = 0, $x = 0; $i < $count; $i++) {
                    if ($products[$x]->id === $products_with_quantity[$i]['product_id']) {
                        $products[$x]->quantity = $products_with_quantity[$i]['quantity'];
                        $x++;
                    } else {
                        unset($products_with_quantity[$i]);
                        $DatabaseDeletedProduct = true;
                        Cache::decrement(Cookie::get('unique_id') . '.number_of_products_in_cart');
                    }
                }
            } else {
                $DatabaseDeletedProduct = true;
                unset($products_with_quantity);
            }
        } else {
            $products = new Collection();
        }

        if ($DatabaseDeletedProduct) {
            if (isset($products_with_quantity)) {
                $products_with_quantity  = array_values($products_with_quantity);

                return response()->view('cart', compact('products'))
                                 ->cookie('cart_product_IDs', serialize($products_with_quantity), 12 * 60);
            } else {
                return response()->view('cart', compact('products'))->cookie(Cookie::forget('cart_product_IDs'));
            }
        }

        return view('cart', compact('products'));
    }

    public function store(Request $request, Product $product)
    {
        $rules = [
            'quantity' => 'required|integer',
        ];

        $messages = [
            'quantity.required' => 'Unos količine je obavezan.',
            'quantity.integer' => 'Količina mora biti cijeli broj.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $productIDs = Cookie::get('cart_product_IDs');
        if (null === $productIDs) {
            $value[0]['product_id'] = $product->id;
            $value[0]['quantity'] = $request->input('quantity');
            $visitor = Cookie::get('unique_id');
            if (null === $visitor) {
                return back()->withCookie(cookie('cart_product_IDs', serialize($value), 12 * 60))
                             ->withCookie(cookie('unique_id', uniqid('', true), 2628000));
            }
            Cache::increment($visitor . '.number_of_products_in_cart');

            return back()->withCookie(cookie('cart_product_IDs', serialize($value), 12 * 60));
        } else {
            $products = unserialize($productIDs);
            $value['product_id'] = $product->id;
            $value['quantity'] = $request->input('quantity');
            $products[] = $value;
            Cache::increment(Cookie::get('unique_id') . '.number_of_products_in_cart');

            return back()->withCookie(cookie('cart_product_IDs', serialize($products), 12 * 60));
        }
    }

    public function update(Request $request)
    {
        $quantities = $request->input('quantities');
        $quantities = explode(',', $quantities);

        $rules = [
            'quantities' => 'array',
            'quantities.*' => 'integer',
        ];

        $messages = [
            'quantities.*.integer' => 'Količine moraju biti cijeli broj.',
        ];

        $validator = Validator::make(compact('quantities'), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->getMessageBag()->toArray()]);
        }

        $products = unserialize(Cookie::get('cart_product_IDs'));
        for ($i = 0; $i < count($products); $i++) {
            $products[$i]['quantity'] = $quantities[$i];
        }

        return response('success')->withCookie(cookie('cart_product_IDs', serialize($products), 12 * 60));
    }

    public function destroy(Request $request)
    {
        $products_with_quantity = collect(unserialize(Cookie::get('cart_product_IDs')));
        $products = $products_with_quantity->pluck('product_id');
        if (false !== ($key = $products->search($request->input('product_id')))) {
            unset($products_with_quantity[$key]);
            $products_with_quantity  = array_values($products_with_quantity->toArray());
        }
        if (count($products_with_quantity) <= 0) {
            Cache::forget(Cookie::get('unique_id') . '.number_of_products_in_cart');

            return response(0)->cookie(Cookie::forget('cart_product_IDs'));
        } else {
            Cache::decrement(Cookie::get('unique_id') . '.number_of_products_in_cart');

            return response(count($products_with_quantity))->cookie(
                'cart_product_IDs',
                serialize($products_with_quantity),
                12 * 60
            );
        }
    }
}
