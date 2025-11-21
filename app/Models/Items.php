<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $primaryKey = 'item_id';
    protected $fillable = [
        'name',
        'sku',
        'rate',
        'unit',
        'tax_id',
        'type',
        'status',
        'description'
    ];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->item_id;
    }

    public function getFullNameAttribute()
    {
        return $this->sku ? $this->name . ' (' . $this->sku . ')' : $this->name;
    }
    public function taxe()
    {
        return $this->belongsTo(Taxes::class, 'tax_id');
    }
}
