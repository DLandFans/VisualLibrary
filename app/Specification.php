<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    protected $fillable = [
        "classification", "icon_file_name", "icon_file_type"
    ];

    protected $hidden = [
//        'created_at', 'updated_at', 'pivot'
    ];

    protected $primaryKey = "specification_id";

    public function plants() {
        return $this->belongsToMany('App\Plant', 'plant_specification', 'specification_id', 'plant_id' )
            ->withPivot("specification_note")
            ->withTimestamps();
    }
}
