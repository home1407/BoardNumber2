<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    @yield('cssNscript')
<style>
#divContent {
    background-color : #f0f0f0;
  padding : 2rem 1.25rem;	
}

#divTitle{
    padding : 2rem 0rem 0rem 0.5rem;
}


#divName p{
    background-color : #CEE3F6;
    border-top : 2px solid #160800;

}
#Center {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  #board_title {
	  overflow: hidden; 
	  text-overflow: ellipsis;
	  white-space: nowrap; 
	  width: 500px;
	  height: 20px;
	}
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height : auto;}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 2000px  ;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }

    .menubar{
        border:none;
        border:0px;
        margin:0px;
        padding:0px;
        font: 67.5% "Lucida Sans Unicode", "Bitstream Vera Sans", "Trebuchet Unicode MS", "Lucida Grande", Verdana, Helvetica, sans-serif;
        font-size:14px;
        font-weight:bold;
        }

        .menubar ul{
        background: rgb(109,109,109);
        height:50px;
        list-style:none;
        margin:0;
        padding:0;
        }

        .menubar li{
        float : left;
        padding:0px;
        }

        .menubar li a{
        background: rgb(109,109,109);
        color:#cccccc;
        display:block;
        font-weight:normal;
        line-height:50px;
        margin:0px;
        padding:0px 25px;
        text-align:center;
        text-decoration:none;
        }

        .menubar li a:hover, .menubar ul li:hover a{
        background: rgb(71,71,71);
        color:#FFFFFF;
        text-decoration:none;
        }

        .menubar li ul{
        background: rgb(109,109,109);
        display:none; /* 평상시에는 드랍메뉴가 안보이게 하기 */
        height:auto;
        padding:0px;
        margin:0px;
        border:0px;
        position:absolute;
        width:200px;
        z-index:200;
        /*top:1em;
        /*left:0;*/
        }

        .menubar li:hover ul{
        display:block; /* 마우스 커서 올리면 드랍메뉴 보이게 하기 */
        }

        .menubar li li {
        background: rgb(109,109,109);
        display:block;
        float:none;
        margin:0px;
        padding:0px;
        width:200px;
        }

        .menubar li:hover li a{
        background:none;
        }

        .menubar li ul a{
        display:block;
        height:50px;
        font-size:12px;
        font-style:normal;
        margin:0px;
        padding:0px 10px 0px 15px;
        text-align:left;
        }

        .menubar li ul a:hover, .menubar li ul li:hover a{
        background: rgb(71,71,71);
        border:0px;
        color:#ffffff;
        text-decoration:none;
        }

        .menubar p{
        clear:left;
        }

        @yield('css')
  </style>
</head>
<body>
    <div class="menubar">
		<ul>
			<li><a href="index.php">Home</a>
				<ul>
				    <li><a href="#">Sliders</a></li>
				    <li><a href="#">Galleries</a></li>
				    <li><a href="#">Apps</a></li>
				    <li><a href="#">Extensions</a></li>
			    </ul>
			</li>
			<li><a href="#" id="current">게시글1</a>
				<ul>
				    <li><a href="#">페페 게시판</a></li>
        <li><a href="{{route('boards.index')}}">유저 게시판</a></li>
				    <li><a href="#">Apps</a></li>
				    <li><a href="#">Extensions</a></li>
			    </ul>
			</li>
			<li><a href="#">게시글2</a>
				<ul>
				    <li><a href="#">Sliders</a></li>
				    <li><a href="#">Galleries</a></li>
				    <li><a href="#">Apps</a></li>
				    <li><a href="#">Extensions</a></li>
			    </ul>
			</li>
			<li><a href="#">게시글3</a>
				<ul>
				    <li><a href="#">문의 게시판</a></li>
				    <li><a href="#">Galleries</a></li>
				    <li><a href="#">Apps</a></li>
				    <li><a href="#">Extensions</a></li>
			    </ul>
      </li>
      
      @if(Auth::check())
				<ul class = "nav navbar-nav navbar-right">
          <li><a href = "{{route('outlog')}}" onclick="$('#out').submit()"><span class="glyphicon glyphicon-log-out"></span> 로그아웃</a></li>
        </ul>
      @else
        <ul class = "nav navbar-nav navbar-right">
          <li><a href = "{{route('register')}}"><span class="glyphicon glyphicon-log-out"></span> 회원가입</a></li>
        </ul>
      @endif
		</ul>
  </div>
  <div class="container-fluid text-center">    
    <div class="row content">
      <div class="col-sm-1 sidenav">
            <p><a href="#"></a></p>
            <p><a href="#"></a></p>
            <p><a href="#"></a></p>
      </div>
      <div class="col-sm-10 text-left">
          @yield("content")
          <div class = "py-4">
              @include('flash::message')
          </div> 
      </div>
      <div class="col-sm-1 sidenav">
      </div>
    @yield('script')
</body>
</html>