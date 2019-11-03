<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function user(){
        return $this->belongsTo(user::class);
    }

    public function boards(){
        return $this->belongsTo(Board::class);
    }
}
