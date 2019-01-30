<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; //沒有引用會錯
use App\Post; //沒有引用會錯
use App\addmessage; //沒有引用會錯
use App\Reply; //沒有引用會錯
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response as x;
use Validator; //引入驗證的類別
class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request); // $request->id 
        $rules =[
            'content' => 'required',//content 這個欄位是 validation required的驗證
        ]; //驗證規則
          $messages =[
            'content.required' =>'請輸入文章內容',
        ]; //錯誤時改寫錯誤訊息
        request()->validate($rules, $messages); //先做驗證 在存資料  使用 Request 類別的 validate 方法

        $messages = $request->only('content'); //變數 存要求欄位 content 是前端的name
        $messages['post_id'] = $request->id; //變數  存要貼文者ID
        // dd($messages);
        // dd($request->id); //有進入
        $message = auth()->user()->addmessage()->create($messages); //驗證後的使用者 留言後 存入資料庫 關聯 傳入show 方式
        // dd($message);
        if($message){ //資料存完回主頁面
            return redirect()->route('post.show',$request->id); //代HTTP請求回去 流水號
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ed_message = addmessage::find($id); //獲得單筆留言
        if(!$ed_message){
            return redirect()->route('post.show'); //重新導向index 方法
        }
        return view('post.message',[ 'ed_message' =>  $ed_message]); // 回前端,代參數
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $params = $request->only('content'); // 存欄位,內容
        $message =  addmessage::find($id); //單筆文章
    
        if (!$message) {
            return redirect()->route('post.index');
        }
    
        $message->update($params);
        return redirect()->route('post.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         // dd($id);
         $message = addmessage::find($id); //找到該留言並刪除
         // dd($id);
         // dd($message);
         if($message){
         
             $postId = $message->post_id;  //回到當前文章 
             // dd($postId); //回到當前文章 
             $message->delete();
             return redirect()->route('post.show', $postId); //刪除後重新導回show畫面
         }
    }

    public function reply(Request $request) //留言的回覆
    {   
        //dd($_COOKIE); //加密的cookie值
        // dd($request->post_id); // $request->id  抓到是哪篇留言
        $rules =[
            'reply_content' => 'required',//content 這個欄位是 validation required的驗證
        ]; //驗證規則
        $messages =[
            'reply_content.required' =>'請輸入文章內容',
        ]; //錯誤時改寫錯誤訊息
        request()->validate($rules, $messages); //先做驗證 在存資料  使用 Request 類別的 validate 方法
        
        $content = $request->only('reply_content'); //變數 存要求欄位 reply_content 是前端的name
        // response('Hello Cookie')->cookie('reply_content', 'sadsa', 60); //做回應
        // $value = $request->cookie('reply_content'); //做要求
        $a = cookie('cs', 'cookie',5);//新建一個Cookie對象,過期時間為5分鐘)($name,$value,$min)
        // return response()->make('湖南省')->cookie($a);
        response()->make('s')->cookie($a); //回應
        // dd(response()->make('s')->cookie($a));

        $messages['message_id'] = $request->id; //變數  留言ID
        $messages['user_id'] = auth()->user()->id ; //變數  存要貼文者ID
        $messages['post_id'] = $request->post_id; //變數  存要貼文者ID
        $messages['content'] = $content['reply_content']; //存入 回復內容
        // dd($messages);
        // dd($request->id); //有進入
        $message = auth()->user()->reply()->create($messages); //驗證後的使用者 留言後 存入資料庫 關聯 傳入show 方式
        // dd($message);
        if($message){ //資料存完回主頁面
            return redirect()->route('post.show',$request->post_id); //代HTTP請求回去 流水號
        }
    }
}
