<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
  public $fillable = [
  	'name', 'username', 'email', 'password'
  ];
  
  public function discuss()
  {
    return $this->hasMany('App\Models\Discuss');
  }
  
  public function comments()
  {
    return $this->hasMany('App\Models\Comment');
  }
}