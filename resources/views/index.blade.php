@extends('layouts.app')

@section('content')
    <h1>유저 게시판</h1>
    <div class = "container">
        <table class = "table table-hover">
            <tr>
                <th>제목</th>
                <th>작성자</th>
                <th>조회수</th>
            </tr>
            @foreach($msgs as $msg)
                <tr>
                    <td>
                        <a href = "{{route('boards.show', ['board'=>$msg->id, 'page'=>$page])}}">
                            {{$msg->title}}
                        </a>
                    </td>
                    @if((isset($searchFilter) ? $searchFilter : "") == 'name')
                        <td>{{$msg->name}}</td>
                    @else
                        <td>{{$msg->user->name}}</td>
                    @endif
                    <td>{{$msg->hits}}</td>
                </tr>
            @endforeach
        </table>
    </div>
    
    @if((isset($keyword)?$keyword:"") == true &&(isset($searchFilter)?$searchFilter:""==true))
        {{$msgs->appends(['keyword'=>$keyword, 'searchFilter'=>$searchFilter])->links()}}
    @else
        {{$msgs->appends(['title'=>$msg->title, 'content'=>$msg->content])->links()}}
    @endif
    <input type = "button" value = "글쓰기" onclick = "location.href = '{{route('boards.create')}}'" class = 'btn btn-primary'>
    <div id = "find">
        <form method = "get" action = '{{route('search')}}' id = "search">
            <select id = "searchFilter" name = "searchFilter">
                <option name = "search" value = "titleContent" selected>제목+내용</option>
                <option name = "search" value = "title">제목</option>
                <option name = "search" value = "name">이름</option>
            </select>
            <input type = "text" id = "searchKeyword" name = 'keyword'>
            <input type = "submit" id = "searchButton" value = "찾기">
        </form>
    </div>

@endsection