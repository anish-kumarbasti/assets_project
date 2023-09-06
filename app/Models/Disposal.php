<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposal extends Model
{
    use HasFactory;
    protected $table = 'disposels';
    protected $fillable = ['category', 'asset', 'period_months', 'asset_value', 'desposal_code','product_id'];
    public function TypeName()
    {
        return $this->belongsTo(AssetType::class, 'category');
    }
    public function assetName()
    {
        return $this->belongsTo(Asset::class, 'asset', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Stock::class, 'product_id', 'id');
    }
}
