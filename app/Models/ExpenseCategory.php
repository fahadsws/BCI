<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model

{
    protected $table = 'expense_category';
    protected $primaryKey = 'expense_category_id';

    protected $fillable = [
        'name'
    ];
    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->expense_category_id;
    }
}
