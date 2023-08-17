<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = ['name', 'brand_id', 'status'];
    public function Asset(){
        return $this->belongsTo('App\Models\AssetType','assettype_id');
    }
}
