<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Domain\Order\ViewModels\OrderViewModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function store(Request $request, string $category, string $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $extra = [
            'title' => $product->title,
            'status' => 0,
        ];

        if (auth()->check()) {
            $user = auth()->user();
            $extra['user_id']  = $user->id;
            $extra['username'] = $user->username;
            $extra['email']    = $user->email;
            $extra['phone']    = $user->phone;
        } else {
            $guest = session('guest_order_user', []);
            $extra['username'] = $guest['username'] ?? null;
            $extra['email']    = $guest['email']    ?? null;
            $extra['phone']    = $guest['phone']    ?? null;
            session()->forget('guest_order_user');
        }

        $order = OrderViewModel::make()->create($extra, $request);

        // Гостю запоминаем номер заказа в сессии для проверки доступа
        if (!auth()->check()) {
            session()->push('guest_orders', $order->number);
        }

        return redirect()->route('order.show', ['number' => $order->number]);
    }

    public function show(string $number)
    {
        $order = Order::where('number', $number)->firstOrFail();

        if (auth()->check()) {
            abort_if($order->user_id !== auth()->id(), Response::HTTP_FORBIDDEN);
        } else {
            $guestOrders = session('guest_orders', []);
            abort_if(!in_array($order->number, $guestOrders), Response::HTTP_FORBIDDEN);
        }

        return view('order.order', compact('order'));
    }
}
