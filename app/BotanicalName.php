<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BotanicalName extends Model
{
    protected $fillable = [
        "genus_name", "specific_epithet", "variety_name", "cultivar_name", "hybrid_genus", "hybrid_epithet", "trademarked"
    ];

    protected $hidden = [
//        'created_at', 'updated_at'
    ];

    protected $primaryKey = "botanical_id";

    public function plants() {
        return $this->belongsTo('App\Plant', 'plant_id');
    }
}
