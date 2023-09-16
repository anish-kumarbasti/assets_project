<?php

namespace App\Models;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Maintenance extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'asset_number', 'supplier_id', 'asset_price', 'start_date', 'end_date', 'status'];
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
    public function statuss()
    {
        return $this->belongsTo(Status::class, 'status');
    }
    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
