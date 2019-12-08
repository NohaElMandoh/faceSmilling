<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class FaceStatus extends Model 
{

    protected $table = 'face_status';
    public $timestamps = true;
    protected $fillable = array('status');

    public function capture_imgs()
    {
        return $this->hasMany('App\CaptureImg');
    }

}