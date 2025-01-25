<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Spatie\Permission\Models\Role;

class SubscriptionController extends Controller
{
    public function __construct(){
        $this->middleware(
            'permission:list_plans',
            [
                'only' => [
                    'index'
                ]
            ]
        );

        $this->middleware(
            'permission:manage_plans',
            [
                'only' => [
                    'redirectToStripe'
                ]
            ]
        );
    }

    public function index()
    {
        $plans = Plan::all();
        return view('subscriptions.index', compact('plans'));
    }

    public function redirectToStripe(Request $request, $plan_id){

        $plan = Plan::where('id', $plan_id)
        ->first();

        if (!$plan) {
            return redirect()->route('subscriptions.index')->withErrors(['error' => 'The plan does not exist.']);
        }

        // Ensure the plan price is valid
        $priceAmount = $plan->price * 100; // Convert to cents for Stripe
        
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        // Create a price object dynamically for the checkout session
        $price = \Stripe\Price::create([
            'unit_amount' => $priceAmount,
            'currency' => 'usd', // Adjust the currency as needed
            'product_data' => [
                'name' => $plan->name,
            ],
        ]);

        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
              'price' => $price->id,
              'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkout.cancel', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            
        ]);

        $order = new Order();
        $order->plan_id = $plan->id;
        $order->user_id = $request->user()->id;
        $order->status = 'pending';
        $order->total_price = $plan->price;
        $order->session_id = $checkout_session->id;
        $order->save();

        return redirect($checkout_session->url);

    }

    public function success(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $session_id = $request->get('session_id');

        $session = $stripe->checkout->sessions->retrieve($session_id);

        if(!$session){
            throw new NotFoundHttpException;
        }

        $order = Order::where('session_id', $session_id)->where('status', 'pending')->with('plan')->first();
        if(!$order){
            throw new NotFoundHttpException;
        }

        $order->status = 'paid';
        $order->save();

        Subscription::create([
            'user_id' => $order->user_id,
            'plan_id' => $order->plan_id,
            'subscribed_at' => now(),
            'expires_at' => now()->addDays($order->plan->duration),
        ]);

        // This section is intended to assign a specific role to the customer
        // The role will be tied to the subscription's duration,
        // allowing the user to access the website and its features during the subscription period.

        // $userRole = Role::where('name', 'user')->first();
        // if (!$userRole) {
        //     $userRole = Role::create(['name' => 'user']);
        // }

        // $order->user()->assignRole($userRole);

        return view('subscriptions.success', compact('order'));
    }

    public function cancel()
    {
        return view('subscriptions.cancel');
    }

}

