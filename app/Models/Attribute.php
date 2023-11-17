<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function asset_type()
    {
        return $this->belongsTo(AssetType::class, 'asset_type_id');
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class,'attribute','id');
    }
}
