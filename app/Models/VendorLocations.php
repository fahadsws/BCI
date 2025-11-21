<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorLocations extends Model
{
    protected $primaryKey = 'vendor_location_id';

    protected $fillable = ['vendor_id', 'vendor_service_area_id'];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->vendor_location_id;
    }
}
