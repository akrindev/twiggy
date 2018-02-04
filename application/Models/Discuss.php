<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discuss extends Model
{
  protected $table = "discuss";
  protected $fillable = [
  	'user_id', 'topic', 'body', 'tags'
  ];
  public $timestamps = true;
  
  public function user()
  {
    return $this->belongsTo('App\Models\User');
  }
}