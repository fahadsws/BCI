<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
   protected $primaryKey = 'vehicle_id';

   protected $fillable = ['name', 'status'];

   // ID ALIAS
   public function getIdAttribute()
   {
      return $this->vehicle_id;
   }
}
