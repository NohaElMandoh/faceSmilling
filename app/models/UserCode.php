<?php

namespace App\models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Model;

class UserCode extends Model 
{

    protected $table = 'users_codes';
    public $timestamps = true;
    protected $fillable = array('user_id', 'code','user_code_id');

    public function colorful_attempts()
    {
        $dtime = DateTime::createFromFormat("d/m G:i",  $item->pivot->created_at);
        $timestamp= Carbon::createFromFormat('Y-m-d H:m:s', $request->created_at)->timestamp;
        return $this->belongsToMany('App\models\ColorfulImgs')->withPivot('status');
    }

    public function match_attempts()
    {
       
        return $this->belongsToMany('App\models\CaptureImg')->withPivot('status', 'path','matching','ellapsed_time');
    }

    public function partition_attempts()
    {
        return $this->belongsToMany('App\models\PartitionImg')->withPivot('status');
    }

    public function user()
    {
        return $this->belongsTo('\User');
    }

}