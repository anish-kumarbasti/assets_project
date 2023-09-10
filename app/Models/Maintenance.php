<?php

namespace App\Models;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Maintenance extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'asset', 'supplier', 'asset_price', 'start_date', 'end_date'];
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
        return $this->belongsTo(Stock::class, 'product_id');
    }
}
