<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;
    protected $fillable = ['asset', 'supplier', 'type', 'start_date', 'end_date'];
    public function assets()
    {
        return $this->belongsTo(Asset::class, 'name');
    }
}
