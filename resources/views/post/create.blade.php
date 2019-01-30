@extends('layouts.app') 

@section('content')
    <div class="container">
        <form action="{{ route('post.store') }}" method="POST"> <!-- 把資料送進後端post . store 存取資料  -->
            @csrf
            <div class="form-group row">
                <label for="title" class="col-sm-1 col-form-label">標題</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="title" name="title" placeholder="標題">
                    
                    @if ($errors->first('title')) <!-- 當驗證沒過時  會渲染errors變數 blade 能夠從 errors 變數取出錯誤訊息，並顯示於畫面 -->
                    <span class="error" role="alert">
                        <strong>{{ $errors->first('title') }}</strong> <!-- 驗證失敗時彈出錯誤訊息  -->
                    </span>
                  @endif 
                </div>
            </div>
            <div class="form-group row">
                <label for="content" class="col-sm-1 col-form-label">內容</label>
                <div class="col-sm-4">
                    <textarea class="form-control" id="content" name="content"> 
                    </textarea> <!--收content -->

                    @if ($errors->first('content')) <!-- 當驗證沒過時  會渲染errors變數 blade 能夠從 errors 變數取出錯誤訊息，並顯示於畫面 -->
                    <span class="error" role="alert">
                        <strong>{{ $errors->first('content') }}</strong>  <!-- 驗證失敗時彈出錯誤訊息  -->
                    </span>
                     @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input type="submit" class="btn btn-primary" value="送出">
                </div>
            </div>
        </form>
    </div>
@endsection