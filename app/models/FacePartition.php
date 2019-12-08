<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class FacePartition extends Model 
{

    protected $table = 'face_partitions';
    public $timestamps = true;
    protected $fillable = array('name');

    public function imgs_partition()
    {
        return $this->hasMany('App\PartitionImg');
    }

}