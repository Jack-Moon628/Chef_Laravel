<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\User;
use Nikolag\Square\Facades\Square;
use Nikolag\Square\Models\Customer;


class OrderController extends Controller
{
    public function order(Request $request)
    {
        $order = new Order;
        // $user = Auth::user();
        $order->total = $request->total;
        $square = Square::setOrder($order, env('SQUARE_LOCATION'));
        $square->charge([
            'amount' => 10.00,
            'card_nonce' => $request->nonce,
            'locationId' => env('SQUARE_LOCATION')
        ]);
        $order = $square->getOrder();
        //return view('new_register', compact('title'));
        return response()->json(compact('order'));
    }
}

