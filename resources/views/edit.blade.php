@extends('layouts.app')
@section('cssNscript')
  <link href="/dist/dropzone.css" rel="stylesheet">
  <script src="/dist/dropzone.js"></script>
  <script src="/bower_components/jquery/dist/jquery.js"></script>
  <script src="/bower_components/tui-code-snippet/dist/tui-code-snippet.js"></script>
  <script src="/bower_components/markdown-it/dist/markdown-it.js"></script>
  <script src="/bower_components/to-mark/dist/to-mark.js"></script>
  <script src="/bower_components/codemirror/lib/codemirror.js"></script>
  <script src="/bower_components/highlightjs/highlight.pack.js"></script>
  <script src="/bower_components/squire-rte/build/squire-raw.js"></script>
  <script src="/bower_components/tui-editor/dist/tui-editor-Editor.min.js"></script>
  <link rel="stylesheet" href="/bower_components/codemirror/lib/codemirror.css">
  <link rel="stylesheet" href="/bower_components/highlightjs/styles/github.css">
  <link rel="stylesheet" href="/bower_components/tui-editor/dist/tui-editor.css">
  <link rel="stylesheet" href="/bower_components/tui-editor/dist/tui-editor-contents.css">
@endsection
@section('content')
    <form id = "store" action = "{{route('boards.update', ['board'=>$board->id, 'page'=>$page])}}" method = "post">
        @csrf
        @Method('PATCH') <!--웹 브라우저는 get, post 밖에 못쓰지만 메소드 퍼포밍을 통해 patch 메소드도 사용가능하다.(수정)-->
        <div class = "form-group">
        <label for = "title">제목</label>
            <input type = "text" name = "title" value = "{{$board->title}}" class = "form-control">
            <span>
                @if( $errors->has('title') )
                    {{ $errors->first('title') }}
                @endif
            </span>
        </div>

        <div class="form-group">
            <label for="content">내용:</label>
            <textarea class="form-control" rows="5" id="content" name="contents"
            required>{{old('content')}}{{$board->content}}</textarea>

            <span>
                @if( $errors->has('content') )
                    {{ $errors->first('content') }}
                @endif
            </span>

        <div><h3>첨부파일</h3></div>      
            <ul>
                 @forelse($board->attachments as $attach)
                    <li>
                        <a href="{{'/files/' . Auth::user()->id . '/' . $attach->filename}}">
                        {{$attach->filename}} 
                        </a>
                        <input type="checkbox" class="glyphicon glyphicon-trash" value="{{$attach->id}}" name="del_attachments[]"> Delete
                    </li>
                    @empty <li>첨부파일 없음</li> 
                @endforelse 
            </ul>
    </form>
    <form action="{{route('attachments.store')}}"
        class="dropzone"
        id="dropzone" method="post" enctype="multipart/form-data">
        @csrf
    </form>
    <div style="margin:10px 0 50px 0" >
        <button type="submit" class="btn btn-primary offset-md-1" onclick="$('#store').submit()">수정</button>
        <a class="btn btn-danger offset-md-1" href="{{route('boards.index',['page'=>$page])}}">목록보기</a>
      </div>
    </div>
    @include('dropzone')

    </script>
    @endsection
    