<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'status'];
    public function users()
    {
        return $this->hasMany(User::class,'location_id','id');
    }
    public function issuances()
    {
        return $this->hasMany(Issuence::class,'location_id','id');
    }
    public function sublocations()
    {
        return $this->hasMany(SubLocationModel::class,'location_id','id');
    }
}
