<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadTypes extends Model
{
    protected $primaryKey = 'lead_type_id';
    protected $fillable = ['name', 'color'];
    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->lead_type_id;
    }
}
