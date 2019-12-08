<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class PartitionImg extends Model 
{

    protected $table = 'partitions_imgs';
    public $timestamps = true;
    protected $fillable = array('face_partitions_id', 'ques', 'path', 'user_id');

    public function partitions()
    {
        return $this->belongsTo('App\FacePartition');
    }

    public function user_attempt()
    {
        return $this->belongsToMany('App\User');
    }

}