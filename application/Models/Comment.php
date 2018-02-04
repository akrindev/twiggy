<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  protected $fillable = [
  	'user_id', 'parent_id', 'body'
  ];
  public $timestamps = true;
  
  
  public function user()
  {
    return $this->belongsTo('App\Models\User');
  }
}