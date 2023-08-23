<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = ['name', 'brand_id','assettype_id', 'status'];
    public function AssetName(){
        return $this->belongsTo('App\Models\AssetType','assettype_id','id');
    }
}
