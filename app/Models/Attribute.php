<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function asset_type()
    {
        return $this->belongsTo(AssetType::class, 'asset_type_id');
    }
}
