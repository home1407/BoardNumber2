@extends('layouts.app')
@section('content')

        <div id = "divTitle">
            <p class="h2"> 
                {{$board->title}}
            </p>
        </div>


    <div id = "divName">
        <p>{{$board->user->name}}</p>
    </div>                               <!-- 
                                                내부적으로 join을 통해 값을 select 했다.
                                           -->
    <div id = "divContent">
        {{$board->content}}
    </div>

        <table = "Table">
        <tr>
            <th>첨부파일</th>
            <td>			
                <ul>
                @forelse($board->attachments as $attach)
                    <li>
                        <a href="{{'/files/' . Auth::user()->id . '/' . $attach->filename}}">
                        {{$attach->filename}}
                        </a>
                    </li>
                @empty <li>첨부파일 없음</li>	
                @endforelse	
                </ul>
            </td>
        </tr>		
    </table class = "Table">

    <hr>
    <h3>댓글 리스트</h3>
    <div class = "container">
        <table class = "table table-hover">
            @foreach($board->comments as $c)
                <tr>
                    <th>작성자</th>
                    <th>내용</th>
                </tr>
                <tr>
                    <td>{{$c->user->name}}</td>
                    <td>{{$c->content}}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <form method = "post" id="commentStore" action='{{route('comments.store', ['page'=>$page,
        'board'=>$board->id])}}' >
        <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea class="form-control" rows="5" id="write_comment" name = "content"></textarea><br>
            @csrf
            <input type = "hidden" id = "board_id" name = "bId" value = {{$board->id}}>
        @if(Auth::check())
            <input type = "hidden" id = "user_id" name = "id" value = {{Auth::user()->id}} >
        @endif
        </div>
    </form>
    <div id = "commentBtn">
        <input type = "button" value = "댓글 등록" class = "btn btn-primary" onclick="$('#commentStore').submit()">
    </div>
    <br>
    <div class = "row">
        <button class = "btn btn-primary" onclick = "location.href ='{{route('boards.index', ['page' => $page]) }}' ">목록보기</button>
        @if(Auth::id() == $board->user_id)    <!--(Auth::user()->id == $board->user_id)--> 
            <button class = "btn btn-waring" onclick = "location.href = '{{route('boards.edit', ['page'=>$page, 'board'=>$board->id])}}'">수정</button>
        <button class = "btn btn-danger" id = "deleteButton" onclick = "deleteClicked()">삭제</button>
        @endif
    </div>

@endsection

@section('script')
    <script>
        function deleteClicked(){
            if(confirm('글을 삭제 하시겠습니까?')) {
                $.ajax({
                url: '{{route("boards.destroy", ["bb"=>$board->id])}}',
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                success: function(data) {
                    if(data == 'true') {
                                location.href="{{route('boards.index', ['page'=>$page])}}";
                    }
                },
                });
            }
        }
		
	</script>

