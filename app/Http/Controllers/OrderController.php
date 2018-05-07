<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::with('orderProducts')->where('user_id', '=', Auth::user()->id)->get();
        return view('user_order_list', compact('orders'));
    }

    public function show(Order $order)
    {
        if (Auth::check() && (Auth::user()->id === $order->user_id || Auth::user()->admin)) {
            $order->load(['orderProducts.product' => function ($query) {
                // soft deleted products are displayed in the users order history too
                $query->withTrashed();
            }]);
            return view('user_order', compact('order'));
        } else {
            return view('errors.404');
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $products_with_quantity = unserialize(Cookie::get('cart_product_IDs'));
        if ($products_with_quantity !== false) {
            $product_IDs = collect($products_with_quantity)->pluck('product_id');
            $product_ids_ordered = implode(',', $product_IDs->toArray());
            $products = Product::whereIn('id', $product_IDs)->orderByRaw(
                DB::raw("FIELD(id, $product_ids_ordered)")
            )->get();
            $count = count($products_with_quantity);
            if ($products->count() !== 0) {
                for ($i = 0, $x = 0; $i < $count; $i++) {
                    if ($products[$x]->id == $products_with_quantity[$i]['product_id']) {
                        $products[$x]->quantity = $products_with_quantity[$i]['quantity'];
                        $x++;
                    }
                }
            }
        } else {
            return back();
        }

        $order = new Order();
        $order->remark = $request->input('remark', '');

        $order = $user->orders()->save($order);

        $products->each(function ($item, $key) use (&$order) {
            $order->orderProducts()->create([
                'product_id' => $item->id,
                'quantity' => $item->quantity
            ]);
        });

        Cache::increment('unopened_order_count');

        Cache::forever(Cookie::get('unique_id') . '.number_of_products_in_cart', 0);

        return response()->view('thanks_for_order', compact('user', 'order'))
                         ->withCookie(Cookie::forget('cart_product_IDs'));
    }

    public function getAllOrders()
    {
        $orders = Order::with('user')->get();

        return Datatables::of($orders)
            ->editColumn('created_at', function (Order $order) {
                Carbon::setLocale('hr');
                return $order->created_at->format('d.m.Y. H:i:s') . " (" . $order->created_at->diffForHumans() . ")";
            })
            ->addColumn('actions', function (Order $order) {
                $actions = '<a href='. route('admin.user.order.show', ['order' => $order]) .
                    '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428bca" title="Pregledaj narudžbu"></i></a>';
                return $actions;
            })->rawColumns(['actions'])->make(true);
    }

    public function orderDetails(Order $order)
    {
        if (! $order->read_by_admin) {
            $order->timestamps = false;
            $order->read_by_admin = true;
            $order->save();
            Cache::decrement('unopened_order_count');
        }

        $order->load(['orderProducts.product' => function ($query) {
            // soft deleted products are displayed in the users order history too
            $query->withTrashed();
        }]);

        $user = User::select('name', 'postal', 'city', 'address', 'email', 'phone')->find($order->user_id);

        return view('admin.order_details', compact('order', 'user'));
    }
}
