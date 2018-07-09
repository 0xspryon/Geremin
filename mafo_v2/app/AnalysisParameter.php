<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisParameter extends Model
{
    protected $fillable = [ 'name_analysis_parameter' ];

    public function analysis(){
        return $this->belongsTo('App\Analysis');
    }
    //
}
