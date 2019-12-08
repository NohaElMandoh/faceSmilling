<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartitionImgUser extends Model 
{

    protected $table = 'partition_img_user';
    public $timestamps = true;
    protected $fillable = array('partition_img_id', 'status', 'user_id');

}