<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourJsons extends Model
{
    protected $primaryKey = 'tour_json_id';

    protected $fillable = ['tour_id', 'json'];
    // ID ALIAS 
    public function getIdAttribute()
    {
        return $this->tour_id;
    }
    public function tour()
    {
        return $this->belongsTo(Tours::class, 'tour_id');
    }
}
