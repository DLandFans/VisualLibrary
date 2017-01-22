<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlantImage extends Model
{
    protected $fillable = [
        "file_name", "file_type", "image_desc"
    ];

    protected $hidden = [
//        'created_at', 'updated_at', 'plant_id', 'image_id'
    ];

    protected $primaryKey = "image_id";

    public function plants() {
        return $this->belongsTo('App\Plant', 'plant_id');
    }

}
