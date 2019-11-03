<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Board;
class CheckOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //로그인한 사용자와, 요청 정보에 있는
        //게시글의 id를 이용해 게시글을 db에서 가져오고, 그 가져온 게시글의 user_id와 비교
        //다르면 back
        $user = Auth::user();
                                        //update는 patch방식이라 boards/update/{board paremeter} 이런식으로 url이 넘어옴
                                        //get 방식처럼 id를 request 할 수가 없다.
                                        //그러므로 board라는 route에서 값을 찾는다.
        $id = $request->route('board'); //이 board라는 route에 id정보가 들어있다
        $b = Board::find($id);
        if($b==false || $user->id != $b->user_id){
            flash("권한이 없습니다")->error();
            return back();
        }
        return $next($request);
    }
}
