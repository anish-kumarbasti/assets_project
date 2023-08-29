<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposal extends Model
{
    use HasFactory;
    protected $table = 'disposels';
    protected $fillable = ['category', 'asset', 'period_months', 'asset_value', 'desposal_code'];
}
