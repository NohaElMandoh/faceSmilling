<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColorfulImgUser extends Model 
{

    protected $table = 'colorful_img_user';
    public $timestamps = true;
    protected $fillable = array('colorful_img_id', 'status', 'user_id','selected_color');

}