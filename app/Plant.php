<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    protected $fillable = [
        'genus_name',
        'specific_epithet',
        'variety_name',
        'cultivar_name',
        'hybrid_genus',
        'hybrid_epithet'
    ];

    protected $primaryKey = "plant_id";

}
