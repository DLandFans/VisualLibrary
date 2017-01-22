<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlantNote extends Model
{
    protected $fillable = [
        "note"
    ];

    protected $hidden = [
//        'created_at', 'updated_at'
    ];

    protected $primaryKey = "note_id";

    public function plants() {
        return $this->belongsTo('App\Plant', 'plant_id');
    }
}
