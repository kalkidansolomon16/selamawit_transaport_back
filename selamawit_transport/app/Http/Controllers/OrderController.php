<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Vehicle;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
   
    public function index()
    {
     
        return response()->json([
            'orders' => Order::all(),
            'message'=>'Success'
        ]);
        
    }


    public function create()
    {
     
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'order_name'=>'required|min:3',
            'client_name'=>'required|string',
            'plate_number'=>'required|string',
            'driver_name'=>'required|string',
            'phone_number'=>'required|string',
            'loading_place'=>'required|string',
            'destination'=>'required|string',
            'load_type'=>'required|string',
            'quintal'=>'required|float',
            'given_tariff'=>'required|float',
            'sub_tariff'=>'required|float',
            'total_revenue'=>'required|float',
            'revenue'=>'required|float',
            'to_be_paid'=>'required|float',
            'arrival_at_loading_site'=>'required|date',
            'loading_date'=>'required|date',
            'current_condition'=>'required|string',
            'truks_owner'=>'required|string',
            'payment_collected'=>'required|string',
            'payment_done'=>'required|string',
            'month'=>'required|string',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'error'=>$validator->messages(),
            ],422);
        }
        else{
            $order = new Order();
            $order->order_name = request('order_name');
            $order->client_name = request('client_name');
            $order->plate_number = request('plate_number');
            $order->driver_name = request('driver_name');
            $order->phone_number = request('phone_number');
            $order->loading_place = request('loading_place');
            $order->destination = request('destination');
            $order->load_type = request('load_type');
            $order->quintal = request('quintal');
            $order->given_tariff = request('given_tariff');
            $order->sub_tariff = request('sub_tariff');
            $order->total_revenue = request('total_revenue');
            $order->revenue = request('revenue');
            $order->to_be_paid = request('to_be_paid');
            $order->arrival_at_loading_site = request('arrival_at_loading_site');
            $order->loading_date = request('loading_date');
            $order->current_condition = request('current_condition');
            $order->truks_owner = request('truks_owner');
            $order->payment_collected = request('payment_collected');
            $order->payment_done = request('payment_done');
            $order->month = request('month');
            $order->save();
            return response()->json([
                'status'=>'Success'
            ]);
        }

    }
              
    public function show($id)
    {
        $order = Order::find($id);
        return response()->json([
            'order'=>$order
        ]);

    }

    public function edit($id)
    {
        $order = Order::find($id);
        return response()->json([
            'order'=>$order,
            'message'=>'Success'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'order_name'=>'required|min:3',
            'client_name'=>'required|string',
            'plate_number'=>'required|string',
            'driver_name'=>'required|string',
            'phone_number'=>'required|string',
            'loading_place'=>'required|string',
            'destination'=>'required|string',
            'load_type'=>'required|string',
            'quintal'=>'required|float',
            'given_tariff'=>'required|float',
            'sub_tariff'=>'required|float',
            'total_revenue'=>'required|float',
            'revenue'=>'required|float',
            'to_be_paid'=>'required|float',
            'arrival_at_loading_site'=>'required|date',
            'loading_date'=>'required|date',
            'current_condition'=>'required|string',
            'truks_owner'=>'required|string',
            'payment_collected'=>'required|string',
            'payment_done'=>'required|string',
            'month'=>'required|string',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,                                                                                                                                                                                                                                                                                                                                                                                                                                                      
                'error'=>$validator->messages(),
            ],422);
        }
        else{

            $order = new Order();
          $order->order_name = request('order_name');
            $order->client_name = request('client_name');
            $order->plate_number = request('plate_number');
            $order->driver_name = request('driver_name');
            $order->phone_number = request('phone_number');
            $order->loading_place = request('loading_place');
            $order->destination = request('destination');
            $order->load_type = request('load_type');
            $order->quintal = request('quintal');
            $order->given_tariff = request('given_tariff');
            $order->sub_tariff = request('sub_tariff');
            $order->total_revenue = request('total_revenue');
            $order->revenue = request('revenue');
            $order->to_be_paid = request('to_be_paid');
            $order->arrival_at_loading_site = request('arrival_at_loading_site');
            $order->loading_date = request('loading_date');
            $order->current_condition = request('current_condition');
            $order->truks_owner = request('truks_owner');
            $order->payment_collected = request('payment_collected');
            $order->payment_done = request('payment_done');
            $order->month = request('month');
            $order->save();
            return response()->json([
                'status'=>'Success'
            ]);
        }
        
    }



 

    /**
     * Update the specified resource in storage.
     */

    public function destroy($id)
    {
        $order = Order::find($id);
        if($order){

            $order->delete();
            return response()->json([
                'status'=>'Order Deleted Successfully',
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'No User foud by this id'
            ]);
        }
    }
     public function count()
    {

        $orderCount = Order::count();
        return response()->json([
            'count' => $orderCount,
            'message' => 'Order count retrieved successfully'
        ]);
    }
    public function totalRevennue()
    {
        $totalRevenue = Order::sum('total_revenue');
        return response()->json([
            'total_revenue' => $totalRevenue,
            'message' => 'Total revenue retrieved successfully'
        ]);
    }
}
