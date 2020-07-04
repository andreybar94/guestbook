<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
  public function user()
  {
    return $this->belongsTo('App\User');
  }
  /**
   * Получить имя пользователя, который оставил данное сообщение
  */
  public function getNameAttribute()
  {
    return $this->user->name;
  }
  /**
   * Получить id авторизованного пользователя
  */
  public function getAuthIdAttribute()
  {
      return Auth::user()->id;
  }

}