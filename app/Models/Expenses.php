<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    protected $primaryKey = 'expense_id';

    protected $fillable = [
        'date',
        'category_id',
        'vendor_name',
        'amount',
        'reference',
        'client_id',
        'tour_id',
        'notes',
        'quotation_id',
        'type'
    ];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->expense_id;
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }
    public function client()
    {
        return $this->belongsTo(Tourists::class, 'client_id');
    }
    public function tour()
    {
        return $this->belongsTo(Tours::class, 'tour_id');
    }

    public function quotation()
    {
        return $this->belongsTo(Quotations::class, 'quotation_id');
    }
}
