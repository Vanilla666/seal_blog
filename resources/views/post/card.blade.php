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

<div class="post-preview">
                <form action="{{ route('personal.card_img')}}" method="post" enctype="multipart/form-data"> <!--  上傳圖片route = personal.card_img -->
                {{ csrf_field() }}
                <label for="">選擇一個 60 X 60 PNG的IMG</label><br>
                <input type="file" name="photo[]" id="photo" accept=".jpg"  multiple="true" > <!-- 輸入的檔案類型 檔案多重輸入   multiple="true" jpg類似jpeg name改陣列後端用foreach做 --><br>
                <button type="submit">submit</button>

                @if ($errors->first('photo')) <!-- 如果不符合規則彈出 錯誤訊息 -->
                        <span class="error" role="alert">
                            <strong>{{ $errors->first('photo') }}</strong>
                        </span>
                @endif

                    </br>  
             
                <hr/>
                
              
                @foreach ($img as $key => $imgs) <!-- 把文章撈出 用後端撈資料 渲染回前端 -->
                <div>
                   曬卡區的相對路徑+檔名:{{ $imgs->path.$imgs->name }}<br>
                   user_name:{{ $imgs->user->name }}</br>
                   user_id:{{ $imgs->user_id  }}</br>
                   用別的方式拿user_name:{{  auth()->user()->get()->where('id',$imgs->user_id)->pluck('name')  }} </br> <!-- 驗證的使用者 用id拿整筆資料後只拿姓名 -->
                   <img src="../card/{{ $imgs->name }} ">  <!--改路徑  ../回上一層 -->
                   <!-- <img src="{{ ".".$imgs->path.$imgs->name }} ">    <!-- 改路徑 -->
                   
                </div>
                @endforeach
             
               
</div>

@endsection