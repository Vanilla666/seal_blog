@extends('layouts.app') 

@section('content')
    <div class="container">      
        <div class="card text-center">
            <div class="card-header">
                標題：{{ $data->title }} <!-- 後端把值傳入到前端  -->
            </div>
            <div class="card-body">
                <h5 class="card-title">
                    作者：{{ $data->user->name }} <!-- post關聯user 拿出姓名  -->
                    文章ID：{{ $data->id }} <!-- post關聯user 拿出姓名  -->
                    </br>
                    @foreach ($visit as $key => $visits) <!-- 拿出單筆文章 用關聯拿出資料 -->
                    瀏覽次數：{{  $visits->clicks  }} 
                    瀏覽的IP：{{  $visits->ip  }}
                    </br>
                    @endforeach
                </h5>
                <p class="card-text">
                    {{ $data->content }}
                </p>
            </div>
            <form action="{{ route('message.store', $data->id) }}" method="POST"> <!-- 連到內部  MessageController 的 store方法 -->
                 
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id }}"> <!-- 單純抓文章ID  -->
                    <label  class="col-sm-1 col-form-label">內容</label> <!-- for=content 給後端用  -->
                <div class="col-sm-4">
                    <textarea class="form-control" id="content" name="content">   </textarea>  <!-- HTTP請求 要 儲存content欄位  -->
                    
                    @if ($errors->first('content')) <!-- 當驗證沒過時  會渲染errors變數 blade 能夠從 errors 變數取出錯誤訊息，並顯示於畫面 -->
                    <span class="error" role="alert">
                        <strong>{{ $errors->first('content') }}</strong> <!-- 驗證失敗時彈出錯誤訊息  -->
                    </span>
                  @endif
                </div>
                    <!-- <input type="hidden" name="_method" value="delete"> -->
                    <button type="submit" class="btn btn-danger" >留言</button> <!-- 繳交到後端 -->
                 
                </form>
            @foreach ($message as $key => $messages) <!-- 迭代 並且把後端送入的  $messages 改為 $message 當作從資料庫拿出的資料-->
             
             <br> <!-- post 單筆文章 對應 user model 的name屬性  -->
             留言:{{ $messages->content }} <!-- 欄位 -->
            
             
             <br>
          
             留言者名字:{{ $messages->user->name  }} <!-- 欄位 -->
             留言者email:{{ $messages->user->email }} <!-- 欄位 -->
             留言者ID:{{ $messages->user_id }} <!-- 欄位 -->
             第幾篇:{{ $messages->post_id }} <!-- 欄位 -->
             流水號:{{ $messages->id }} <!-- 欄位 -->
             創立時間:{{ $messages->created_at }} <!-- 欄位 -->
           
             <form  action="{{ route('message.destroy', $messages->id) }}" method="POST"> <!--  $messages->id 找到當前留言' -->
                @csrf

                @if(  auth()->id() === $messages->user_id)
                <a href="{{ route('message.edit', $messages->id) }}" class="btn btn-primary">編輯</a> <!--  $messages->id -- >
                @endif

                @if(  auth()->id() === $messages->user_id)  <!-- 當前使用者ID === 留言者ID -->
                @method('DELETE')
               
                <button class="btn btn-danger">刪除</button>     <!-- form表單action導向刪除動作 才能刪除 -->
                @endif
            </form>
            
                <form action="{{ route('message.reply'), $messages->id }}" method="POST"> 
                    <div>
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $data->id }}"> <!-- 單純抓文章ID  -->
                    <input type="hidden" name="id" value="{{ $messages->id }}"> <!-- 單純抓留言ID  -->
                        <textarea style="width:300px  "  class="form-control" id="reply_content" name="reply_content">   </textarea>  <!-- HTTP請求 要 儲存content欄位  -->
                        @if ($errors->first('reply_content')) <!-- 當驗證沒過時  會渲染errors變數 blade 能夠從 errors 變數取出錯誤訊息，並顯示於畫面 -->
                        <span class="error" role="alert">
                            <strong>{{ $errors->first('reply_content') }}</strong> <!-- 驗證失敗時彈出錯誤訊息  -->
                        </span>
                         @endif
                         
                        
                         @foreach ($reply_content as $key => $reply_contents)
                         @if(  $reply_contents->message_id === $messages->id)
                           回復:{{ $reply_contents->content }}</br>
                           @endif
                         @endforeach
                        
                        <button type="submit" class="btn btn-danger" >留言</button> <!-- 繳交到後端 -->
                       
                    </div>
                </form>
          
           
         
         @endforeach
       
            <div class="card-footer text-muted">
                發文日期：{{ $data->created_at }}
            </div>
            
            <div align="center">

         

                <form action="{{ route('post.destroy', $data->id) }}" method="POST"> <!-- 單筆文章的動作 -->
                    @csrf
                    @if(  auth()->id() === $data->user_id)  <!-- 當前使用者ID === 貼文者ID -->
                     <a href="{{ route('post.edit', $data->id) }}" class="btn btn-primary">編輯</a>
                   
                    @method('DELETE') <!--  HTTP刪除 -->
                    {{-- <input type="hidden" name="_method" value="delete"> --}}
                    <button class="btn btn-danger">刪除</button>
                     @endif
                </form>
               

            </div>
        </div>
    </div>
@endsection