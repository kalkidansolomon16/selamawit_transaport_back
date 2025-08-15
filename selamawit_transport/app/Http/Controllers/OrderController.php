<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Vehicle;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
   
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 5);
        $orders = Order::paginate($perPage);
        return response()->json([
            'orders' => $orders,
            'message' => 'Success'
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
            'quintal'=>'required|',
            'given_tariff'=>'required|',
            'sub_tariff'=>'required|',
            'total_revenue'=>'required|',
            'revenue'=>'required|',
            'to_be_paid'=>'required|',
            'arrival_at_loading_site'=>'required|date',
            'loading_date'=>'required|date',
            'current_condition'=>'required|string',
            'truks_owner'=>'required|string',
            'payment_collected'=>'required|string',
            'vehicle_id'=>'required|integer',
            // 'payment_done'=>'required|string',
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
            $order->vehicle_id = request('vehicle_id');
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
        $order = Order::find($id);
        
if (!$order) {
    return response()->json([
        'status' => 'Error',
        'message' => 'Order not found',
        'id_received' => $id
    ], 404);
}
        $validator = $request->validate([
            'order_name'=>'required|min:3',
            'vehicle_id'=>'required|integer',
            'client_name'=>'required|string',
            'plate_number'=>'required|string',
            'driver_name'=>'required|string',
            'phone_number'=>'required|string',
            'loading_place'=>'required|string',
            'destination'=>'required|string',
            'load_type'=>'required|string',
            'quintal'=>'required|numeric',
            'given_tariff'=>'required|numeric',
            'sub_tariff'=>'required|numeric',
            'total_revenue'=>'required|numeric',
            'revenue'=>'required|numeric',
            'to_be_paid'=>'required|numeric',
            'arrival_at_loading_site'=>'required|date',
            'loading_date'=>'required|date',
            'current_condition'=>'required|string',
            'truks_owner'=>'required|string',
            'payment_collected'=>'required|string',
            // 'payment_done'=>'required|string',
            'month'=>'required|string',

        ]);
   $order->update($validator);
$order->refresh(); 

return response()->json([
    'status' => 'Success',
    'message' => 'Order updated successfully',
    'orders' => $order
]);

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
                'message'=>'Order Deleted Successfully',

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
    public function monthlyIncome(){
        $incomeByMonth = Order::select(
            'month',
            DB::raw('SUM(total_revenue) as total_revenue')
        )->groupBy('month')->orderByRaw("STR_TO_DATE(month, '%b')")->get();

        return response()->json([
            'monthly_income' => $incomeByMonth,
            'message' => 'Monthly income retrieved successfully'
        ]);
    }
}
