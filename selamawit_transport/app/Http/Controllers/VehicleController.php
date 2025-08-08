<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;


class VehicleController extends Controller
{
   
    public function index()
    {
     
        return response()->json([
            'vehicles' => Vehicle::all(),
            'message'=>'Success'
        ]);
        
    }


    public function create()
    {
     
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'plate_number'=>'required',
            'owner_type'=>'required',
            'owner_name'=>'required|min:8',
            'librey'=>'nullable',
            'owner_phone'=>'required|numeric',
            
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'error'=>$validator->messages(),
            ],422);
        }
        else{

            $vehicle = new Vehicle();
            $vehicle->plate_number = request('plate_number');
            $vehicle->owner_type = request('owner_type');
            $vehicle->owner_name = request('owner_name');
            $vehicle->librey = request('librey');
            $vehicle->owner_phone = request('owner_phone');
            if ($request->hasFile('librey')) {
                $photo = $request->file('librey');
                $photoName = 'ka_l' . time() . '_' . $photo->getClientOriginalName();
                $photo->move(public_path('img'), $photoName);
                $vehicle->librey = 'img/' . $photoName;
            }
            $vehicle->save();
            return response()->json([
                'status'=>'Success'
            ]);
        }
        
    }

 
    public function show($id)
    {
        $vehicle = Vehicle::find($id);
        return response()->json([
            'vehicle'=>$vehicle
        ]);

    }

    public function edit( $id)
    {
        $vehicle = Vehicle::find($id);
        return response()->json([
            'vehicle'=>$vehicle,
            'message'=>'Success'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
           'plate_number'=>'required',
            'librey'=>'nullable',
            'owner_phone'=>'required',
            'owner_name'=>'required',
            'owner_type'=>'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'error'=>$validator->messages()
            ],422);
        }
        else{
            $vehicle = Vehicle::find($id);
            $vehicle->plate_number = request('plate_number');
            $vehicle->librey = request('librey');
            $vehicle->owner_phone = request('owner_phone');
            $vehicle->owner_name = request('owner_name');
            $vehicle->owner_type = request('owner_type');
            $vehicle->update();
            return response()->json([
                'status'=>'Success'
            ]);

        }
    }

  
    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);
        if($vehicle){

            $vehicle->delete();
            return response()->json([
                'status'=>'Vehicle Deleted Successfully',
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
        
        $vehicleCount = Vehicle::count();
        return response()->json([
            'count' => $vehicleCount,
            'message' => 'Vehicle count retrieved successfully'
        ]);
    }
}
