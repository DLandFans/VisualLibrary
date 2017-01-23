<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommonName extends Model
{
    protected $fillable = [
        "common_name"
    ];

    protected $hidden = [
//        'created_at', 'updated_at'
    ];

    protected $primaryKey = "common_id";

    public function plants() {
        return $this->belongsTo('App\Plant', 'plant_id');
    }
}
