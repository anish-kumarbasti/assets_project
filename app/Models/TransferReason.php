<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransferReason extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    public function transfers()
    {
        return $this->hasMany(Transfer::class,'reason_id','id');
    }
}
