<?php

namespace App\Models;

use App\Http\Controllers\Stock\StockController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issuence extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function allStock(){
        return $this->belongsTo(Stock::class,'product_id','id');
    }
}
