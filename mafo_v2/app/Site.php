<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    //
    protected $fillable = [ 'name', 'other_info', 'lat', 'lng'];

    public function drills(){
        return $this->hasMany('App\Drill');
    }

    public function coordinates(){
        return $this->hasMany('App\Coordinate');
    }
}
