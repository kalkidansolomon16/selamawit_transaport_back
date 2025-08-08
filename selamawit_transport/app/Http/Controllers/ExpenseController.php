<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class ExpenseController extends Controller
{
   
    public function index()
    {
     
        return response()->json([
            'expenses' => Expense::all(),
            'message'=>'Success'
        ]);
        
    }


    public function create()
    {
     
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'expense_type'=>'required',
            'name'=>'required',
            'amount'=>'required',
            'date'=>'required|date',
            'from'=>'required',
            'to'=>'required',
            'file'=>'nullable|file',
            'remark'=>'nullable|string',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'error'=>$validator->messages(),
            ],422);
        }
        else{

            $expense = new Expense();
            $expense->expense_type = request('expense_type');
            $expense->name = request('name');
            $expense->amount = request('amount');
            $expense->date = request('date');
            $expense->from = request('from');
            $expense->to = request('to');
            $expense->file = request('file');
            $expense->remark = request('remark');
            if ($request->hasFile('file')) {
                $photo = $request->file('file');
                $photoName = 'ka_l' . time() . '_' . $photo->getClientOriginalName();
                $photo->move(public_path('img'), $photoName);
                $expense->file = 'img/' . $photoName;
            }
            $expense->save();
            return response()->json([
                'status'=>'Success'
            ]);
        }
        
    }

 
    public function show($id)
    {
        $expense = Expense::find($id);
        return response()->json([
            'expense'=>$expense
        ]);

    }

    public function edit( $id)
    {
        $expense = Expense::find($id);
        return response()->json([
            'expense'=>$expense,
            'message'=>'Success'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
           'expense_type'=>'required',
            'name'=>'required',
            'amount'=>'required',
            'date'=>'required|date',
            'from'=>'required',
            'to'=>'required',
            'file'=>'nullable|file',
            'remark'=>'nullable|string',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'error'=>$validator->messages()
            ],422);
        }
        else{
            $expense = Expense::find($id);
            $expense->expense_type = request('expense_type');
            $expense->name = request('name');
            $expense->amount = request('amount');
            $expense->date = request('date');
            $expense->from = request('from');
            $expense->to = request('to');
            $expense->file = request('file');
            $expense->remark = request('remark');
            $expense->update();
            return response()->json([
                'status'=>'Success'
            ]);

        }
    }

  
    public function destroy($id)
    {
        $expense = Expense::find($id);
        if($expense){

            $expense->delete();
            return response()->json([
                'status'=>'Expense Deleted Successfully',
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'No User foud by this id'
            ]);
        }
    }
    public function totalExpense()
    {
        $totalExpense = Expense::sum('amount');
        return response()->json([
            'total_expense' => $totalExpense,
            'message' => 'Total expense retrieved successfully'
        ]);
    }
}
