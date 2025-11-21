<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadTags extends Model
{
   protected $primaryKey = 'lead_tag_id';

   protected $fillable = ['name', 'status'];

   // ID ALIAS
   public function getIdAttribute()
   {
      return $this->lead_tag_id;
   }
}
