<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Profile extends Model
{
  
  protected $fillable = [
    'nickname', 'gender', 'introduction', 'image'
  ];
  
  // Userモデルと１対１のリレーションを張る
  public function user() {
    
    return $this->belongsTo(User::class);
    
  }
  
}
