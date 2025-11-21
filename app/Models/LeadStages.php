<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadStages extends Model
{
    protected $primaryKey = 'lead_stage_id';

    protected $fillable = [
        'name',
        'btn_bg',
        'btn_text'
    ];


    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->lead_stage_id;
    }
}
