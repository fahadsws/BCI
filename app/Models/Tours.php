<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tours extends Model
{
    protected $primaryKey = 'tour_id';

    protected $fillable = [
        'name',
        'day',
        'night',
        'description',
        'status','attachment'
    ];
    // ID ALIAS 
    public function getIdAttribute()
    {
        return $this->tour_id;
    }
    public function tourJsons()
    {
        return $this->hasMany(TourJsons::class, 'tour_id');
    }
}
