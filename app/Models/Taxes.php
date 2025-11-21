<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taxes extends Model

{
    protected $primaryKey = 'taxe_id';

    protected $fillable = [
        'tax_name',
        'rate','company_id'
    ];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->taxe_id;
    }
}
