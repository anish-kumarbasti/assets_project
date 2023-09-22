<?php

namespace App\Models;

use App\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubLocationModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "sublocations";
    protected $fillable = ['name', 'location_id', 'status'];

    public function locations()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
