<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
protected $fillable = [
    'expense_type',
    'name',
    'amount',
    'date',
    'from',
    'to',
    'file',
    'remark'
];
}
