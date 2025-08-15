<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Vehicle;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ExpenseType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class ExpenseTypeController extends Controller
{
   
    public function index(Request $request)
    {
        $perPage = $request->get('per_page',5);
        $expenseType = ExpenseType::with('expense')->paginate($perPage);
     
        return response()->json([
            'ExpenseTypes' =>$expenseType,
            'message'=>'Success'
        ]);
        
    }


    public function create()
    {
     
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'expense_id'=>'required|integer',
            'category'=>'required|string',
         
          
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'error'=>$validator->messages(),
            ],422);
        }
        else{
            $expenseType = new ExpenseType();
            $expenseType->expense_id = request('expense_id');
            $expenseType->category = request('category');

            $expenseType->save();
            return response()->json([
                'status'=>'Success'
            ]);
        }

    }
              
    public function show($id)
    {
        $expenseType = ExpenseType::find($id);
        return response()->json([
            'expense_type'=>$expenseType
        ]);

    }

    public function edit($id)
    {
        $expenseType = ExpenseType::find($id);
        return response()->json([
            'expense_type'=>$expenseType,
            'message'=>'Success'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $expenseType = ExpenseType::find($id);
        $validator = $request->validate([
'expense_id'=>'required',
'category'=>'required'

        ]);
        $expenseType->update($validator);
        $expenseType->refresh();
        return response()->json([
            'message'=>'Expense Type Updated Success Fully',
            'expenseType'=>$expenseType
        ]);
  

    }
           
        
        
    



 

    /**
     * Update the specified resource in storage.
     */

    public function destroy($id)
    {
        $expenseType = ExpenseType::find($id);
        if($expenseType){

            $expenseType->delete();
            return response()->json([
                'status'=>'Expense Type Deleted Successfully',
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

        $expenseCount = ExpenseType::count();
        return response()->json([
            'count' => $expenseCount,
            'message' => 'Expense Type count retrieved successfully'
        ]);
    }
 
}
