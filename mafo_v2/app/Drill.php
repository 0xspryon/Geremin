<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drill extends Model
{
    protected $fillable = [ 'code' , 'lat' , 'lng' , 'alt' ];

    public function sites(){
        return $this->belongsTo('App\Site');
    }
    //
}
