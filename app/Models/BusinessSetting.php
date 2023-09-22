<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSetting extends Model
{
    use HasFactory;

    // app/Models/BusinessSetting.php

protected $fillable = [
    'logo_path',
];
    // app/Models/BusinessSetting.php

public function setLogoPathAttribute($value)
{
    $this->attributes['logo_path'] = $value;
}

}
