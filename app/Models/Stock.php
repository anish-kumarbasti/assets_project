<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $guarded=[];
    
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
    public function assetmain()
    {
        return $this->belongsTo(Asset::class, 'asset');
    }
    public function asset_type()
    {
        return $this->belongsTo(AssetType::class, 'asset_type_id');
    }
    public function brandmodel(){
        return $this->belongsTo(Brandmodel::class, 'brand_model_id');
    }
}
