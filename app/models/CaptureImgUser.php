<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaptureImgUser extends Model 
{

    protected $table = 'capture_img_user';
    public $timestamps = true;
    protected $fillable = array('capture_img_id', 'user_id', 'status', 'path', 'matching', 'ellapsed_time');

}