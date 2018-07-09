<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coordinate extends Model
{
    protected $fillable = ['lat', 'lng', 'alt'];

    public function site(){
        return $this->belongsTo('App\Site');
    }
}
