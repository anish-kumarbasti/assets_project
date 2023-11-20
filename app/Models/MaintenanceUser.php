<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceUser extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function reason(){
        return $this->belongsTo(TransferReason::class,'maintenance_reason','id');
    }
}
