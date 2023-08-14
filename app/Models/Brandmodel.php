<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brandmodel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'brand_id',
        'status'
    ];
    public function Brandmodel(){
        return $this->belongsTo('App\Models\Brand','brand_id');
    }
}
