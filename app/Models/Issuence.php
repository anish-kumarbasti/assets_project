<?php

namespace App\Models;

use App\Http\Controllers\Stock\StockController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issuence extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id', 'employee_id');
    }
    public function assettype()
    {
        return $this->belongsTo(AssetType::class,'asset_type_id');
    }
    public function asset()
    {
        return $this->belongsTo(Asset::class,'asset_type_id');
    }
    public function product()
    {
        return $this->belongsTo(Attribute::class,'asset_type_id');
    }
}

//asset_type_id	
//asset_id	
//product_id