<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    protected $fillable = [
        "classification"
    ];

    protected $hidden = [
//        'created_at', 'updated_at', 'pivot', 'class_id'
    ];

    protected $primaryKey = "class_id";

    public function plants() {
        return $this->belongsToMany('App\Plant', 'plant_classification', 'class_id', 'plant_id' )
            ->withTimestamps();
    }


}
