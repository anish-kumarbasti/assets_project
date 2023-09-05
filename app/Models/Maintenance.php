<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;
    protected $fillable = ['asset_type_id','asset_number', 'supplier_id','product_id', 'asset_id', 'start_date', 'end_date'];
    public function assetType()
    {
        return $this->belongsTo(AssetType::class, 'asset_type_id');
    }
    public function assetName()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
    public function supplierName()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function product()
    {
        return $this->belongsTo(stock::class, 'product_id');
    }
}
