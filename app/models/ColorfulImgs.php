<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ColorfulImgs extends Model 
{

    protected $table = 'colorful_imgs';
    public $timestamps = true;
    protected $fillable = array('photo', 'color', 'users_id');

    

    public function attempts()
    {
        return $this->belongsToMany('App\User')->withPivot('status','selected_color');
    }

}