<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timeline extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Define the User relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define the Product (Stock) relationship
    public function product()
    {
        return $this->belongsTo(Stock::class, 'product_id');
    }

    // Define the Issuance relationship
    public function issuance()
    {
        return $this->belongsTo(Issuence::class, 'issuance_id');
    }

    // Define the Transfer relationship
    public function transfer()
    {
        return $this->belongsTo(Transfer::class, 'transfer_id');
    }

    // Define the Disposal relationship
    public function disposal()
    {
        return $this->belongsTo(Disposal::class, 'disposal_id');
    }

    // Define the Maintenance relationship
    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class, 'maintenance_id');
    }

    // Define the Return relationship
    public function assetReturn()
    {
        return $this->belongsTo(AssetReturn::class, 'return_id');
    }
}

