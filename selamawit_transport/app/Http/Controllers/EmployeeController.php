<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;


class EmployeeController extends Controller
{
   
    public function index()
    {
     
        return response()->json([
            'employees' => Employee::all(),
            'message'=>'Success'
        ]);
        
    }


    public function create()
    {
     
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|min:3',
            'employee_type'=>'required',
            'phone'=>'nullable|numeric',
            'file'=>'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'error'=>$validator->messages(),
            ],422);
        }
        else{
            $employee = new Employee();
            $employee->name = request('name');
            $employee->employee_type = request('employee_type');
            $employee->phone = request('phone');
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = 'emp_' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('files'), $fileName);
                $employee->file = 'files/' . $fileName;
            }
            $employee->save();
            return response()->json([
                'status'=>'Success'
            ]);
        }

    }
    public function show($id)
    {
        $employee = Employee::find($id);
        return response()->json([
            'employee'=>$employee
        ]);

    }

    public function edit($id)
    {
        $employee = Employee::find($id);
        return response()->json([
            'employee'=>$employee,
            'message'=>'Success'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
           'name'=>'required|min:3',
            'employee_type'=>'required',
            'phone'=>'nullable|numeric',
            'file'=>'nullable|file|mimes:jpg,png,pdf|max:2048',
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



 

    /**
     * Update the specified resource in storage.
     */

    public function destroy($id)
    {
        $employee = Employee::find($id);
        if($employee){

            $employee->delete();
            return response()->json([
                'status'=>'Employee Deleted Successfully',
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

        $employeeCount = Employee::count();
        return response()->json([
            'count' => $employeeCount,
            'message' => 'Employee count retrieved successfully'
        ]);
    }
}
