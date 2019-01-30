@extends('layouts.app') 

@section('content')
    <div class="container">
        <form action="{{ route('post.browse') }}" method="POST"> <!-- 收尋  -->

            @csrf
            <input type="text" class="form-control" id="search" name="search"   value="{{ old('search') }}" > <!--在把session 資料 撈出   -->  
            <button type="submit" class="btn btn-danger" >收尋</button> <!-- 繳交到後端 -->
            
              @if ($errors->first('search')) <!-- 當驗證沒過時  會渲染errors變數 blade 能夠從 errors 變數取出錯誤訊息，並顯示於畫面 -->
                    <span class="error" role="alert">
                        <strong>{{ $errors->first('search') }}</strong> <!-- 驗證失敗時彈出錯誤訊息  -->
                    </span>
                  @endif
        </form>
        
      
        <div align="center">
        <a href="{{ route('post.loading') }}" class="btn btn-primary">loading個人專區</a> <!-- 到show  -->
        <a href="{{ route('personal.index') }}" class="btn btn-primary">個人專區</a> <!-- 把資料送進personal.create -->
        <a href="{{ route('personal.card') }}" class="btn btn-primary">曬卡區專區</a> <!-- 連結personal.card -->
        <a href="{{ route('post.create') }}" class="btn btn-primary">我要貼文</a> <!-- 把資料送進post.create -->
        <a href="{{ route('post.partial_update') }}" class="btn btn-primary">部分更新測試</a> <!-- 把資料送進post.create -->
      
        </div>
        <!-- 資料存取完後 把它從資料勞出  -->
        @foreach ($datas as $key => $data)
       
            <div class="card text-center">
                <div class="card-header">
              
                    標題：{{ $data->title }}
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        作者：{{ $data->user->name }} <!-- post關聯user name  -->
                    </h5>
                    <a href="{{ route('post.show', $data->id) }}" class="btn btn-secondary">查看文章</a> <!--  經過路由導向到show功能 把主鍵送入後勞出資料 -->
                </div>
                <div class="card-footer text-muted">
                    發文日期：{{ $data->created_at }}

                </div>
            </div><br>
        @endforeach
        
        {{ $datas->links() }} <!--  生成內部剩餘鏈結  appends(['sort' => 'votes']) 附加到分頁鏈接的查詢字符串  fragment() 附加分頁鏈結的未尾 -->
    </div>
    </div>
        <!-- 資料存取完後 把它從資料勞出  -->
       
    </div>
  
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
      <script>
            // $.ajax({
            //     type: 'POST', //傳送類型
            //     url: '/post/draw', // uri
            //     data: { date : '2015-03-12'}, //測試資料
            //     dataType: 'json', //傳送的資料類型
            //     headers: { //擋頭
            //     'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') //XSRF-TOKEN cookie 中儲存 CSRF token
            // },
            //     success: function(data){ //成功顯示
            //     console.log(data.status); //印出成功狀態
            // },
            //     error: function(xhr, type){ //錯誤彈出
            //     alert('Ajax error!')
            //     }
            // });

      </script>
    </body>

</html>

@endsection