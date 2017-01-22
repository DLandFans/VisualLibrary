<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlowerColor extends Model
{
    protected $fillable = [
        "color"
    ];

    protected $hidden = [
//        'created_at', 'updated_at', 'pivot'
    ];

    protected $primaryKey = "flower_color_id";

    public function plants() {
        return $this->belongsToMany('App\Plant', 'plant_flower_color', 'flower_color_id', 'plant_id' )
            ->withTimestamps();
    }
}
