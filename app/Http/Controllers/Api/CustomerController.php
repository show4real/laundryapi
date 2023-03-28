<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Events\OrderCreated;

class CustomerController extends Controller
{
    public function addOrder(Request $request){

        $order = new Order();
        $order->customer_name = $request->customer_name;
        $order->customer_address = $request->customer_address;
        $order->customer_phone = $request->customer_phone;
        $order->customer_latitude = $request->customer_latitude;
        $order->customer_longitude = $request->customer_longitude;
        $order->vendor_id = $request->vendor_id;
        $order->order_date = now();
        $order->pending = 1;
        $order->completed = 0;
        $order->cancel = 0;
        $order->accept = 0;
        $order->save();
        
       
        foreach($request->products as $product){
            $order_product = new OrderProduct();
            $order_product->product_id = $product;
            $order_product->order_id = $order->id;
            $order_product->vendor_id = $request->vendor_id;
            $order_product->save();
        }
        event(new OrderCreated());

        return response()->json(compact('order'));
    }
}
