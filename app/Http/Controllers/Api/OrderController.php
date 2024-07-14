<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        try {
            // Fetch all orders from the database
            $orders = Order::all();

            // Return a JSON response with the orders
            return response()->json([
                'status' => 200,
                'orders' => $orders,
            ]);
        } catch (\Exception $e) {
            // Log the error message for debugging
            Log::error('Error fetching orders: ' . $e->getMessage());

            // Return a JSON response with the error message
            return response()->json([
                'status' => 500,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
