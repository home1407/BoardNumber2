<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = [
        'id', 'title', 'content','user_id','hits'
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function user(){
        return $this->belongsTo(User::class);
        //관계형 데이터베이스 형성
        //ex)$board(Board 모델 변수)->user(user의 id)
        //원래는 안되지만 관계를 맺어줬다. 그러므로 이것은 join을 한 것과 같고 내부적으로 join을 통해 select 한다.
        //$board->user의 값과 user 테이블의 값을 비교해서 select 한다.
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function attachments(){
        return $this->hasMany(Attachment::class);
    }
}
