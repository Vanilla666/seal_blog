@extends('layouts.app') 

@section('content')
    <div class="container">
        <form action="{{ route('message.update', $ed_message->id) }}" method="POST"> <!-- 送出更新目前內容  -->
            @csrf
            @method('PUT')

            <div class="form-group row">
                <label for="content" class="col-sm-1 col-form-label">內容</label>
                <div class="col-sm-4">
                    <textarea class="form-control" id="content" name="content">{{ $ed_message->content }}</textarea>
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