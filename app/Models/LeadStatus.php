<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadStatus extends Model
{
    protected $fillable = [
        'name',
        'type_id',
        'btn_bg',
        'btn_text'
    ];

    protected $table = 'lead_status';

    protected $primaryKey = 'lead_status_id';

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->lead_status_id;
    }
    public function type()
    {
        return $this->belongsTo(LeadTypes::class, 'type_id');
    }
}
