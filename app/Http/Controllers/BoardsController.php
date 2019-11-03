<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Board;
use App\Attachment;

class BoardsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('own')->only(['update', 'destroy']); //미들웨어에 ☆등록☆한 own를 쓰겠다, update와 destroy때만
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        $page = $request->page;
        $msgs = Board::orderBy('created_at','desc')->paginate(10);
        return view('index')->with('msgs', $msgs)  //index view를 리턴할 때 msgs라는 이름의 $msgs 값과 page라는 이름의 $page 값을 함께 넘겨준다
              ->with('page',$page);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('write_form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->middleware('auth');
        //1.사용자 입력한 게시글 정보를 boards 테이블에 insert(title, content)
        //auth의 사용자 정보를 받아오기 Auth::user()->id; //auth의 user의 id 정보 받기
        $user = Auth::user(); 
        //DB::insert('insert into boards(title, content, user_id) values(?,?,?', [$reqeust->title, $reqeust->content, $user->id]);
        $board = new Board;
        //$title = isset($_REQUEST["title"])?$_REQUEST["title"]:"";
        //$contents = isset($_REQUEST["contents"])?$_REQEUST["contents"]:"";
        $title = $request->get("title");
        $content = $request->get("contents");
        $board->title = $title;
        $board->content = $content;
        $board->user_id = Auth::user()->id;
        $board->save();
        $boardId = $board->id;

        // // \Log::debug('BBSController store', ['attachments'=>$request->attachments]);
	    if($request->has('attachments')) {
		    foreach($request->attachments as $aid) {
		    $attach = Attachment::find($aid);
		    $attach->board_id=$boardId;
	     	$attach->save();
		    }
         }

        return redirect(route('boards.index', ['page'=>1])); //글을 쓰고 controller의 index를 redirect 하고 매개변수로 page라는 이름의 1을 쓴다.
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $page = $request->page;
        $board = Board::find($id);
        $board->hits++;
        $board->save();
        return view('show')->with('board', $board)
                ->with('page', $page);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $page = $request->page;
        $b = Board::find($id);
        return view('edit')->with('board', $b)->with('page', $page);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //수정하고자 하는 글이 로그인한 사용자의 글인지 체크
        //그렇지 않으면 back()
        $this->validate($request, [
            'title'=>'required',
            'contents'=>'required'
        ]);   //타이틀, 콘텐츠 값 체크 무조건 있어야함
        $b = Board::find($id);
        $page = $request->page;
        $b->title = $request->title;
        $b->content = $request->contents;
        $b->save();
        $boardId = $b->id;

        if($request->has('attachments')) {
		    foreach($request->attachments as $aid) {
		    	$attach = Attachment::find($aid);
		    	$attach->board_id=$boardId;
		    	$attach->save();
		    }
		} 
		if($request->has('del_attachments')) {
			foreach($request->del_attachments as $did) {
				$attach = Attachment::find($did);
				$attach->deleteAttachedFile($attach->filename);
				$attach->delete();
			}
        }  	
        
        return redirect(route('boards.show', ['page'=>$request->page, 'board'=>$boardId]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $page = $request->get("page");
		
		$msg = Board::find($id);
		$msg->delete();
		$attachments = $msg->attachments;
		if($attachments) {
			foreach($attachments as $attach) {
				$attach->deleteAttachedFile($attach->filename);
				$attach->delete();
			}
		}
		flash('message', $id . '번 게시글이 삭제 되었습니다');
		/*
		return redirect(route('bbs.index',['page'=>$page]))->with('message', $id.'번 게시글이 삭제 되었습니다');
		*/
		return response()->json('true', 200);
    }

    public function myArticles(Request $request) {
        $msgs = Board::where('user_id', Auth::user()->id)->orderBy("created_at", 'desc')->paginate(10);
        return view('index')->with('msgs', $msgs)->with('page', 1);
    }

    public function search(Request $request){
        $searchFilter = $request->searchFilter;
        $keyword = $request->keyword;
        if($searchFilter =="title"){
            $msgs = Board::where('title','LIKE', "%$keyword%")->orderBy('created_at', 'desc')->paginate(10);
        }else if($searchFilter == "name"){
            $msgs = User::select(['users.name','boards.title','boards.hits','boards.created_at'])
            ->join('boards', 'boards.user_id', '=', 'users.id')
            ->where('users.name', 'LIKE', "%$keyword%")->orderBy('created_at', 'desc')->paginate(10);
        }else if($searchFilter == "titleContent"){
            $msgs = Board::where(['content'=> $keyword, 'title'=>$keyword])->orderBy('created_at', 'desc')->paginate(3);
        }
        return view('index')->with('msgs', $msgs)->with('page', 1)->with( 'searchFilter',$searchFilter)->with('keyword',$keyword);
    }

}
