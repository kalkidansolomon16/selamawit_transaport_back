<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Nette\Schema\Expect;

class ExpenseController extends Controller
{
   
    public function index(Request $request)
    {
        $perpage = $request->get('per_page', 5);
        $expense = Expense::paginate($perpage);

        return response()->json([
            'expenses' => $expense,
            'message' => 'Success'
        ]);
        
    }


    public function create()
    {
     
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'order_id'=>'required|',
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
            $expense->order_id = request('order_id');
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
        $expense = Expense::find($id);
        $validator = $request->validate([
            'expense_type'=>'required',
            'name'=>'required',
            'amount'=>'required',
            'date'=>'required|date',
            'from'=>'required',
            'to'=>'required',
            'file'=>'nullable|file',
            'remark'=>'nullable|string',
        ]);
        $expense->update($validator);
        $expense->refresh(); 
        return response()->json([
            'message'=>'Expense Updated Successfully',
            'expense'=>$expense
        ]);
    
    
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
    public function totalOrderExpense($id)
    {
        $totalExpenses = Expense::select('order_id',DB::raw('SUM(amount) as total_expense'))->where('order_id', $id)->groupBy('order_id')->get();
        return response()->json([
            'totalExpenses' => $totalExpenses,
            'message' => 'Expenses retrieved successfully'
        ]);
    }
    public function monthlyExpense(){
        $expenseByMMonth = Expense::select(
            DB::raw("DATE_FORMAT(date, '%b') as month"),
            DB::raw("SUM(amount) as total_expense")
        )
       ->groupBy(DB::raw("DATE_FORMAT(date, '%b')"))
    ->orderByRaw("MIN(date)")
    ->get();

    return response()->json([
        'monthly_expenses' => $expenseByMMonth
    ]);
    }
}

