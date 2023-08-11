<?php

namespace App\Models;

use App\Http\Controllers\Master\LocationController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubLocationModel extends Model
{
    use HasFactory;
    protected $table = "sublocations";
    protected $fillable = ['name', 'location_id'];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
