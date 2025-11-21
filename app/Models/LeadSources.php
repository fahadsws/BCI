<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadSources extends Model
{
    protected $primaryKey = 'lead_source_id';

    protected $fillable = ['name'];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->lead_source_id;
    }
}
