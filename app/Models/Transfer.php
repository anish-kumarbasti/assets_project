<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'employee_id','employee_id');
    }
    public function handoveruser()
    {
        return $this->belongsTo(User::class, 'handover_employee_id','employee_id');
    }
    public function manager()
    {
        return $this->belongsTo(User::class, 'employee_manager_id');
    }
    public function handovermanager()
    {
        return $this->belongsTo(User::class, 'handover_manager_id');
    }
    public function reason()
    {
        return $this->belongsTo(TransferReason::class, 'reason_id');
    }
    public function product()
    {
        return $this->belongsTo(Stock::class, 'product_id', 'id');
    }
}
