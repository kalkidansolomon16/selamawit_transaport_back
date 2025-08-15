<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
      public function expense(){
        return $this->belongsTo(Expense::class);
    }
protected $fillable = [
  'expense_id',
  'category'
];
}
