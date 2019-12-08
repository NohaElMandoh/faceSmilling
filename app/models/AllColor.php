<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class AllColor extends Model 
{

    protected $table = 'all_colors';
    public $timestamps = true;
    protected $fillable = array('name', 'hex');

    public function colorfulImgs()
    {
        return $this->hasMany('App\ColorfulImgs');
    }
    public function user()
    {
        return $this->belongsToMany('App\User')->withTimestamps();;
    }
}