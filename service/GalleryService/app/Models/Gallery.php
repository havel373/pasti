<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public $table = "galleries";
    use HasFactory;
    public $timestamps = false;
    // public function getImageAttribute()
    // {
    //     return asset($this->photo);
    // }
}
