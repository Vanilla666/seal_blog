<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // 引用 HTTP請求
use Illuminate\Http\Response; // 引用 HTTP回應
use App\Http\Controllers\Controller; //控制 可有可無
use Redirect, Input, Auth, Log;  // test
use App\User; //沒有引用會錯
use App\Post; //沒有引用會錯
use App\addmessage; //沒有引用會錯
use App\Reply; //沒有引用會錯
use Validator; //引入驗證的類別
use App\VisitorRegistry; //Model
use App\Http\Requests\Post\Store; //  驗證logic 抽離 封裝成獨立的類別
use Illuminate\Contracts\Support\JsonabletoJson; //將頁面的資料 轉換為 JSON 這裡或許不需要
use Illuminate\Support\Facades\Cookie; // 通過Cookie Facade 方式 獲取Cookie
use Visitor; // 套件
//use Weboap\Visitor\Visitor as x; //變數衝突 這裡 use  Visitor::log(); 
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $visitor;

    //依赖注入
    public function __construct(Visitor $visitor){
        $this->visitor = $visitor;

    }
    
    public function index()
    {
        
       //$datas = Post::get(); // 把資料從Post model勞出 獲得全部資料 用for each 印出
    //    $users = auth()->user()->paginate(2);  // 傳遞給paginate方法的唯一參數是您希望“每頁”顯示的項目數
    //    dd($users);
       //dd( $posts = Post::orderBy('id', 'desc')->with('user')->paginate(10) );
    //    $datas = Post::orderBy('id', 'desc')->get() ; // 拿時間倒序
   
       $datas = Post::orderBy('id', 'desc')->with('user')->paginate(3) ; // 拿時間倒序
       
    //    $users = Post::orderBy('id', 'desc')->with('user')->paginate(1); // 拿到post(model) 相關 user(model)   並且以3個為一單位
    //    return User::paginate(1); //轉換成JSON 用來傳遞資料 可以做傳遞數量的過濾
    //    $users->withPath('personal'); // 連結分頁把路由重新導向 withPath(uri) 

    // Visitor::log(1);
       //dd($datas); //Post->id 哪篇文章

    
    // $a = cookie('cs', 'cookie',5);//新建一個Cookie對象,過期時間為5分鐘)($name,$value,$min)
    // response()->make('s')->cookie($a); //回應
    //    $x = Cookie::queue('wang', 'very good', 1); //set  cookie 柱列 後 
    //    dd(Cookie::get('wang')); //get 拿出
       return view('post.index',['datas' => $datas ]); // 渲染index.blade.php 把 後端的資料傳送到前端
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas = Post::get(); // 把資料從Post model勞出 獲得全部資料 用for each 印出
        return view('post.create'); // 渲染 create.blade.php 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) // HTTP請求 
    {  //把資料存入導向到其他功能最後印出資料
        
        $parameters = $request->only('title','content'); //存欄位 跟內容
        $rules =[
            'title' => 'required', //title 這個欄位是 validation required的驗證
            'content' => 'required',//content 這個欄位是 validation required的驗證
        ]; //驗證規則
        $messages =[
            'title.required' => '請輸入文章標題', // title 欄位的 validation required的驗證錯誤改寫
            'content.required' =>'請輸入文章內容',
        ]; //錯誤時改寫錯誤訊息
        $result = Validator::make( $parameters,$rules,$messages); // 先做存取 再做驗證
        if($result->fails()){ // 驗證失敗導向
            return redirect()->route('post.create')->withErrors($result); //導向 creat方法 並且帶
        }
        // request()->validate($rules, $messages); //先做驗證 在存資料  使用 Request 類別的 validate 方法
    

        // $parameters = $request->only('title','content'); //存欄位 跟內容
        $data = auth()->user()->posts()->create( $parameters); //  關聯 經過驗證的使用者 經過關聯把資料存入 posts資料表的title content欄位
        if($data){ //資料存完回主頁面
            return redirect()->route('post.index'); //重新導回 index方法
        }
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function show($id) // 獲得的流水號  這則貼文
    {
        // dd(
        //     Post::find($id)->visitors()->get() //  拿出單筆文章 用關聯拿出資料
        // );
        // dd(
        //     Reply::where('message_id',49)->get()
        // );
        //文章ID 被 回復 ID 被吃掉了 
        // dd($id);
        $data = Post::find($id); //獲得單筆文章的資料
        if(!$data){
            return redirect()->route('post.index'); //如果資料不存在重新導向index方法
        }
        $message = addmessage::where('post_id', $id)->orderBy('created_at', 'desc')->get(); // 限制 找到文章ID 拿該筆資料全部
        // dd(Post::with('addmessage')->orderBy('created_at', 'desc')->get() ); //post 關聯 addmessage 然後倒序排序最後拿出全部
        // dd($message); // 全部留言
        if(!$message){ 
            return redirect()->route('post.show'); //如果留言不存在重新導向show方法
        }
        // $reply = Post::find($id)->addmessage()->pluck('id')->all(); //藉由ID 撈另一個ID 
        // dd($reply);
       
        // dd($message);
        // $tx = addmessage::find($reply);
        // $reply_content = Reply::where('message_id',$reply[0])->get(); //全部回復
        // dd($reply_content);
       
        // dd($$reply_content);
        Visitor::log($data->id);  //可以調用 文章瀏覽 請加入 use Visitor Model 
        $reply_content =Reply::get();
        if(!$reply_content){ 
            return redirect()->route('post.show'); //如果留言不存在重新導向show方法
        }
        //$article = Visitor::get('127.0.0.1'); //把瀏覽資料單筆全部拿出
        // $article = Visitor::all()->where('post_id', $id); //把瀏覽資料全部拿出  限制後 拿出單筆文章
        // $test =  Visitor::log($data->id);
        // dd($test);
        $visit = Post::find($id)->visitors()->get(); //  拿出單筆文章 用關聯拿出資料
      
        //dd($visit);
        //$visit = VisitorRegistry::where('post_id', $id)->get(); //把瀏覽資料全部拿出  限制後 拿出單筆文章
   
            
       // }
        return view('post.show',['data'=>$data, 'message' => $message, 'visit' => $visit,'reply_content' =>$reply_content  ]); //如果資料存在導回show.blade.php 並把data傳回前端
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) //獲得的流水號
    {
        $data = Post::find($id); //獲得單筆文章
        if(!$data){
            return redirect()->route('post.index'); //重新導向index 方法
        }
        return view('post.edit',[ 'data' => $data]); // 回前端,代參數
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
        $params = $request->only('title', 'content'); // 存欄位,內容
        //dd($params); // 把存的參數拿出
        $data = Post::find($id); //單筆文章
    
        if (!$data) {
            return redirect()->route('post.index');
        }
    
        $data->update($params);
        return redirect()->route('post.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) //
    {
        $data = Post::find($id);
        //dd($data); //全部留言  
        $test = addmessage::where('post_id', $id)->get()->all(); // 限制 找到文章ID 拿該筆資料全部 陣列 但是有很多陣列 所以可能要計算長度一個個刪
        //dd($test[0]->content); // 拿到第一個留言後刪除
        // count($test); //計算長度留言陣列長度 
        // dd(count($test));
        // $message = $test[0]->id;
        //dd($message); //全部留言    
        if ($data) {
            // addmessage::destroy();
            for($i=0,$message_count = count($test);$i<$message_count ;$i++){
                $message = $test[$i]->id; // 拿出每個留言的ID 
                // dd($message);
                addmessage::destroy($message); // 然後刪除留言
                Post::destroy($id); //刪除該邊文章
            }
          
            // addmessage::destroy($message);
            //$data->delete();
           
            return redirect()->route('post.index');
        }
    }

    public function load() // 等待頁面 
    {
        header("Refresh:0; url = /personal");  //php 跳轉頁面  Refresh:幾秒 uri 重新導向 相對位置 後
        //不能使用 header("Refresh:0; url = http://localhost:8000/post/browse");  //php 跳轉頁面  Refresh:幾秒 uri 重新導向 相對位置
        //header("Refresh:5; url =http://localhost:8000/personal");
        return view('post.loading'); // 渲染 loading.blade.php  先
        
    }
    public function browse(Request $request) //瀏覽文章ID
    {
       
        // header("Refresh:0; url = ./loading");  //php 跳轉頁面  Refresh:幾秒 url 重新導向 相對位置
        $rules =[
            'search' => 'required',//content 這個欄位是 validation required的驗證
        ]; //驗證規則
          $text =[
            'search.required' =>'請輸入要收尋的標題',
        ]; //錯誤時改寫錯誤訊息
        request()->validate($rules, $text); //先做驗證 在存資料  使用 Request 類別的 validate 方法
        // dd($request->input('search')); //可以是 直接取出前端所打的值
        // respone('ff')->cookie('ee','222',30);
        // $cookie = Cookie::get('search');
        // dd($cookie);
       
        // $cookie = $request->withCookie(cookie()->forever('search',3)); //把收尋的資料 存入cookie
        
        $predata = $request->flashOnly(['search']); //把前端 name="search" 先存進session
        // return redirect('post/index')->withInput($predata); //將輸入資料快閃並重導至前一頁 withInput() 帶入的參數到頁面
        $pre_search = $request->old('search'); //後端在把session 資料 撈出 加快速度
        // dd($pre_search);
        $search = $request->only('search'); //變數 存要求欄位 content 是前端的name 這裡的型態是陣列(array)
        $text = $search['search'];
      
        // sharedLock(); 共享鎖可避免選擇的資料列被更改，直到你的交易提交為止
        // dd( $text);
        // $datas = Post::get(); // 把資料從Post model勞出 獲得全部資料 用for each 印出
        $datas = Post::where('title', 'like', '%'.$text.'%')->orderBy('created_at', 'desc')->sharedLock()->get(); // 做模糊查詢 然後用時間做排序(倒敘) 把拿到的相關結果都拿出
        // dd($datas);
        // dd( count($datas) );
        //$datas_alltitle = $datas->pluck('title')->all(); // piluck後事collcetion 最後是陣列
        //dd(count($datas_alltitle)); //計算陣列長度
        //dd($search['search']); //前端送出form 的瀏覽
        for($i=0,$datas_count = count($datas);$i<$datas_count ;$i++){ //用變數i 當作撈陣列 $datas_alltitle 裡面的value
            $datas_value = $datas[$i]->title;//collcetion 之後指定 array->title 
            echo('用模糊查詢送出標題(PHP): '.$datas_value.'</br>');  //撈出的陣列資料 (文章title)
        }
      

        // while ( current($search) ) { //收尋存在後 做判斷
        //    dd  ( $datas_alltitle ); // current($search) 返回陣列的value
            // if( current($search) == $datas_alltitle ){
            //     dd('OK');
            // }
            // dd($datas_alltitle);
        // }
        //dd($datas->take(3)->get(0)->title); //拿出到第幾筆前 
        // $datas_array = $datas->all(); //先拿出collcetion再拿出裡面的陣列 再拿 key=title 對應 的 value
        // dd($datas_array->length); 
        //dd($datas->get(0)->title);  //collcetion 可以在指定第幾個拿出
        //dd($datas->all());  // 拿出來是 array 
        return view('post.search',['datas' => $datas, 'search' => $search ]); //重新導向到search.blade.php
            
    }
    public function partial_update() //獲得資料json格式
    {
        $timely = Post::get()->pluck('title')->all(); //拿出文章(json)title 給到前端做 即時更新 
        //dd($timely);// 陣列型態
        return view('post.partial_update',['timely' => $timely]); 
    }
    public function ajax_test() //獲得資料json格式
    {
        $ajax_user = User::get()->pluck('id');
        //  dd($ajax_user);
        // response('post.ajax_user',[ 'ajax_user' => $ajax_user]);
    }
  
}
