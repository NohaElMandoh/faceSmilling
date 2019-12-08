<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\models\UserCode;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'api_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
   

    public function colorful_attempts()
    {
        return $this->belongsToMany('App\models\ColorfulImgs','colorful_img_user','user_id','colorful_imgs_id')->withPivot('status','selected_color','created_at')->withTimestamps();
    }
    
    public function match_attempts()
    {
       
        return $this->belongsToMany('App\models\CaptureImg','capture_img_user','user_id','capture_img_id')->withPivot('status', 'path','matching','ellapsed_time')->withTimestamps();
    }

    public function partition_attempts()
    {
        return $this->belongsToMany('App\models\PartitionImg')->withPivot('status')->withTimestamps();;
    }
    public function selectedColor()
    {
        return $this->belongsToMany('App\models\AllColor')->withTimestamps();;
    }
    
}
