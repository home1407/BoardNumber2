<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    //이 컬럼은 배열 형태로 넣을 수 있다.
    protected $fillable = ['filename', 'bytes', 'mime'];
    
    public function boards(){
        return $this->belongsTo(Board::class);
    }

    public function getUrlAttribute() {
    	return url('files/'. \Auth::user()->id . '/' . $this->filename);
    }
    
    function deleteAttachedFile($filename) {
        $path = public_path('files') . DIRECTORY_SEPARATOR .  \Auth::user()->id  . DIRECTORY_SEPARATOR . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
   }
}
