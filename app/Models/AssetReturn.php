<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetReturn extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function username()
    {
        return $this->belongsTo(User::class, 'return_by_user');
    }
    public function products()
    {
        return $this->belongsTo(Stock::class, 'product_id');
    }
}
