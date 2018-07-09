<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    protected $fillable = [ 'analysis_type', 'protocol', 'equipments', 'other_info'];
    //

    public function analysesParameter(){
        return $this->hasMany('App\AnalysisParameter');
    }
}
