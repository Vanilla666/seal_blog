@extends('layouts.app') 

@section('content') <!-- 個人資料 -->


 <head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<title>Clean Blog - Start Bootstrap Theme</title>

<!-- Bootstrap core CSS -->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom fonts for this template -->
<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

<!-- Custom styles for this template -->
<link href="css/clean-blog.min.css" rel="stylesheet">

</head>

<body>



    <div>
    
    
    <div class="container">
        <div class="col-lg-8 col-md-10 mx-auto">
        <div class="post-preview">
        <div>       <h3 class="post-subtitle"> 會員專區 </h3>  <div>  <hr/>
        會員姓名：{{ $user->name }} </br><!-- 用關聯 -->
        會員創立時間：{{ $user->created_at }} </br> <!-- 用關聯 -->
        會員相片存放路徑： {{ $user->img_path }}</br>
        用關聯拿出POST：{{ $user->posts()->get()   }} </br> <!-- get() 拿出時是陣列 要用for each  -->
        </div> <hr/>
            <div class="post-preview">
               
                <h2 class="post-title">
                   你所有發表的文章
                </h2>
                <h3 class="post-subtitle">
                @foreach  ( $user->posts()->get() as $key => $postinfo) <!-- 關聯拿出文章  -->

                <a href="./post/{{$postinfo->id}}"> <!-- 相對路徑導向到該篇文章 + 關聯  -->
                    文章ID：{{ $postinfo->id  }} <!-- 文章流水號  -->
                    文章：{{ $postinfo->title }}
                    內容：{{ $postinfo->content }}
                    <br/>
                @endforeach
                </h3>
                </a>
                <p class="post-meta">Update by
                <a href="#">{{ $user->name }}</a>
              {{ date("Y/m/d") }}</p>  <!-- PHP時間 原生  -->
              <hr/>
            </div>
            
            <div class="post-preview">
                <form action="{{ route('personal.store')}}" method="post" enctype="multipart/form-data"> <!--  上傳圖片 -->
                {{ csrf_field() }}
                <label for="">選擇一個 60 X 60 PNG的IMG</label><br>
                <input type="file" name="file" id="file"   accept=".png" > <!-- 輸入的檔案類型 檔案多重輸入   multiple="true" --><br>
                <button type="submit">submit</button>

                @if ($errors->first('file')) <!-- 如果不符合規則彈出 錯誤訊息 -->
                        <span class="error" role="alert">
                            <strong>{{ $errors->first('file') }}</strong>
                        </span>
                @endif

                <div> 
                    個人PNG_IMG：<img src=" {{ $user->img_path }} "> <!-- public(.)/pdf/826388c826ae55b5befcc7f1c2e77df3.png	  -->
                    </br>  
                </div>
                <hr/>
            </div>
            <div class="post-preview">
            <div>

                文章發表：
                @foreach ($post as $key => $posts) <!-- 把文章撈出 用後端撈資料 渲染回前端 -->
                <div>
                    文章：{{$posts->title}}
                    內容：{{$posts->content}}
                    <br>
                    文章創立：{{$posts->created_at}}
                    文章更新：{{$posts->updated_at}}
                </div>
                @endforeach
                </div>

            </div>
        </div>
    </div>

   
@endsection