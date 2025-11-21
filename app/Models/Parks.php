<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parks extends Model
{
   protected $primaryKey = 'park_id';

   protected $fillable = ['name', 'status'];

   // ID ALIAS
   public function getIdAttribute()
   {
      return $this->park_id;
   }
}
