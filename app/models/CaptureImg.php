<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class CaptureImg extends Model 
{

    protected $table = 'capture_imgs';
    public $timestamps = true;
    protected $fillable = array('path', 'face_status_id', 'users_id');

    public function faceStatus()
    {
        return $this->belongsTo('App\FaceStatus');
    }

    public function user_attempt()
    {
        return $this->belongsToMany('\User');
    }

}