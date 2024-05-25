<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\MessageTrait;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\User;
use App\Payments\Pesapal;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    use MessageTrait;
    //
    public function  finishPayments()
    {
        return view('payments.finish');
    }

    public function cancelPayments()
    {
        return view('payments.cancel');
    }

    public function processOrder(Request $request)
    {
        try {
            //$amount, $phone, $callback
            $request->validate([
                'amount' => 'required|numeric',
                // 'phone_number' => 'required|string',
                'quantity' => 'required|numeric',
            ]);


            $user_id = 3;

            $user_id = User::find($user_id)->id;

            $user_name = User::find($user_id)->name;
            $user_email = User::find($user_id)->email;
            $user_phone = User::find($user_id)->phone_number;

            $first_name = explode(' ', $user_name)[0];
            $last_name = explode(' ', $user_name)[1];


            $quantity = $request->quantity;
            $cooperative_id = 1;
            $delivery_address_id = 1;
            $purchase_cost = $request->amount;
            $delivery_cost = 1200;
            $total_cost = ($purchase_cost * $quantity) + $delivery_cost;
            $quantity = 1;
            $status = 'pending';
            $total_cost = ($purchase_cost * $quantity) + $delivery_cost;
            $order = Order::create([
                'user_id' => $user_id,
                'cooperative_id' => $cooperative_id,
                'delivery_address_id' => $delivery_address_id,
                'purchase_cost' => $purchase_cost,
                'delivery_cost' => $delivery_cost,
                'total_cost' => $total_cost,
                'quantity' => $quantity,
                'status' => $status,

            ]);
            if ($order) {
                // return redirect()->route('productCheckout', ['order_id' => $order->id]);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => 1,
                    'quantity' => $quantity,
                    'price' => $purchase_cost,
                ]);

                // create a transaction
                $reference = str::uuid();
                $transaction = Transaction::create([
                    'type' => 'debit',
                    'order_id' => $order->id,
                    'reference' => $reference,
                    'amount' => $total_cost,
                    'status' => 'pending',
                    'payment_mode' => 'web',
                    'user_id' => $user_id,
                    'cooperative_id' => $cooperative_id,
                    'payment_description' => 'Payment for order ' . $order->id,
                ]);

                // return redirect()->route('productCheckout', ['order_id' => $order->id]);
                $res = Pesapal::orderProcess($reference, $total_cost, $user_phone, 'Payment for order ' . $order->id, route('finishPayment'), $first_name, $last_name, $user_email, $user_id, route('cancelPayment'));

                //  dd($res); 
                if ($res->success) {

                    // return redirect($res->message->redirect_url);
                    return response()->json(['success' => true, 'data' => $res]);
                } else {
                    // dd($res);
                    return response()->json(['success' => false, 'message' => "Something went wrong!Please try again later"]);
                }
            }
        } catch (\Exception $th) {
            // return redirect($request->callback.'?error=1');
            // return response()->json(['success' => false, 'message' => $th->getMessage()]);
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
        // return redirect($request->callback);
    }
}
