<?php

namespace App\Http\Controllers;

// use Symfony\Component\HttpFoundation\Request;
use Illuminate\Http\Request; //HTTP 請求
// use Sami\Sami;
use Illuminate\Support\Facades\Auth; //驗證身分者
use Illuminate\Support\Facades\Storage; //儲存
use Illuminate\Support\Facades\Validator; //驗證相片
use Illuminate\Support\Facades\File; // 檔案上傳
use App\User; //沒有引用會錯 引用 Model
use App\Post; //沒有引用會錯
use App\Personal; //引用 Model
// use DB; //引用
class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //路由 = ./personal/(index可有可無)
    {
        $user = auth()->user(); //驗證使用者  Model 型態 對應 資料表
        $post = auth()->user()->posts()->get(); //撈出該使用者的貼文 用get() 是陣列型態
        //$img = auth()->user()->personal()->get(); //撈出儲存的圖片
        // dd($img);
        return view('post.personal', [
            'user' => $user,
            'post' => $post
        ]); // 渲染 personal.blade.php 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) //存圖片資訊
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)   //  要改存IMG 檔案發送近來處理
    {

        
        // dd($request->all());
        // try{
           // dd( $request->all() );
            // $validator=Validator::make($request->all(),[
            //     'file'=>'required|image'
            // ] ); // 要img 圖片
            $rules = [ //檔案規則
                'file' => 'required|image',
            ];
            $messages = [ //改寫錯誤
                'file.required' => '請輸正確檔案',
            ];
            request()->validate($rules, $messages); //做出參數驗證 擋掉不符合
            //$destinationPath = public_path().'\pdf\\'; //存到的資料夾 2個\\ =\
            $destinationPath = './PersonalImg/'; //測試 ./ = 相對路徑 ../ = 回到上一層
            $CardPath = './card/'; // 存曬卡區的圖片
            // dd($destinationPath); //取出路徑 
            //$file = $request->all(); //拿到上傳後檔案的全部屬性
            $file=$request->file('file');//  file(' 前端name的名字 ') 整個IMG 資料
            if($file == null){ //防止空檔案輸入
                header("Refresh:5; url = ./personal");  //php 跳轉頁面  Refresh:幾秒 url 重新導向 相對位置
                return "不能沒有輸入檔案";
            }
            // dd($file);

            $Img_Size = getimagesize($file); //取得上傳後圖檔的大小($width,$height,$type,$attr) $attr =  width="200" height="55"
            //dd($Img_Size[0]); //拿出時陣列 索引0 = width  索引1 = height 索引2 = type 索引3(attr) = html 的 weight height   
            if($Img_Size[0] >= 60  &&  $Img_Size[1] >= 60){ //如果圖片寬高度 >=60 就顯示該圖片寬高 拿出時陣列 索引0 = width  索引1 = height 索引2 = type 索引3(attr) = html 的 weight height 
                header("Refresh:5; url = ./personal");  //php 跳轉頁面  Refresh:幾秒 url 重新導向 相對位置  
                return "檔案格式錯誤 "."寬:" . $Img_Size[0] . " 高: ". $Img_Size[1];
                //dd( ( "寬:" . $Img_Size[0] . " 高: ". $Img_Size[1]) ); // . =字串相加
            }
            $filename = $file->getClientOriginalExtension(); //檔案副檔名
            // dd($filename);
            $name = $file->getClientOriginalName(); //取得上傳檔案的原始名稱
            $filetype = $file->getMimeType(); //檔案種類
            $unique_name = md5($filename. time()).'.png'; //隨機名字 跟著時間
            // dd( phpinfo() ); //PHP 版本
            if($filetype =='image/png'){ //檔案不符合時
                //$user = Auth::user(); //認證過的使用者
                $user = auth()->user(); //認證過的使用者
                $user->update( ['img_path' => $destinationPath.$unique_name ] );   //更新user img路徑欄位  + 照片檔名
                // Personal::create( //存到 資料表
                //         [ //上傳圖片後 用index方式 裡面用get 撈出資料 再用for each 把資料拿出
                //             'user_id' =>$user->id, //第幾個使用者
                //             'name' => $unique_name, // 檔案名字
                //             'path' =>$destinationPath //路徑
                //         ]
                //     );
            }else{ //檔案不符合時
                header("Refresh:5; url = ./personal");  //php 跳轉頁面  Refresh:幾秒 url 重新導向 相對位置
                return "檔案格式錯誤";
            }
           
            $request->file('file')->move($destinationPath,$unique_name);  //儲存的檔案移動 
           
            return redirect()->route('personal.index'); //重新導向 get方式傳送資料
        // }
        // catch (\Exception $e){
        //     return "發生錯誤";
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show() // 顯示圖片
    {
        // return view('post.card'); // 渲染 personal.blade.php 
        //return redirect()->route('personal.index' ); // 重新導向
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
       
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function card()
    {  
        $ar[4] = 0; //把資料拿出
        $img = Personal::get();
        //dd($img->pluck('name')->all()); //拿圖片檔名
        $personal_img = Personal::get()->pluck('user_id')->all(); // 存的圖片撈出user_id 去對應使用者  陣列
        // $personal_img[0]; //陣列第一個 對應的數值
        // dd( $personal_img );
        for($i=0 ; $i <count($personal_img) ;$i++){
            //    echo($test_img[$i]);
            $user_info = User::find($personal_img[$i]); //關聯後拿使用者名字 陣列 然後去對應本來的名字
            $ar[$i] =  $user_info->name ; //存取給外面
            echo($user_info->name."   ");
            // dd(auth()->user()->get()->where('id',$img->user_id)->pluck('name')->all());
            // $test =User::get();
            // echo($test->firstWhere('name',$ar[$i])->name."   ");
        };
        // $test =User::get();
        // $e = User::get()->where('name',0)->all(); // 拿出User 的全部 變成陣列
        //$img = auth()->user()->personal()->get(); //每個人都有一個頁面
        // $user_info = auth()->user(); //關聯後拿使用者名字 陣列 然後去對應本來的名字
        //dd($user_info->name);
        //  dd(User::get());    
       
         return view('post.card', [ 
             'img' => $img
             ]); // 渲染 personal.blade.php 
    }
    public function cardimg(Request $request)
    {
        $rules = [ //檔案規則 陣列照片驗證 有錯
            'photo' => 'required ', // 'photo' = 前端欄位 沒擋到空直
            'photo.image' => 'mimes:jpeg' //前端的屬性設定
        ];
        $messages = [ //改寫錯誤
            'photo.required' => '請輸入檔案',
            'photo.image' => '不是jpeg',
        ];
        request()->validate($rules, $messages); //做出參數驗證 擋掉不符合   
        $files = $request->file('photo'); //陣列
        $CardPath = './card/'; // 存曬卡區的圖片
        // dd($files[1]->getClientOriginalName()); //拿出陣列型態的檔案原始名子
        if($request->hasFile('photo')){ //多重圖片test
            $i=0;
            foreach($request->file('photo') as $file) { //for each 照片有幾個就做幾次  as $file(抓每次上船的檔案)
                $filename = $file->getClientOriginalName(); //檔案原始名子  
                $img_size = getimagesize($file); //取得上傳後圖檔的大小($width,$height,$type,$attr) $attr =  width="200" height="55"
                // dd($img_size);
                if($img_size[0] >= 1300  &&  $img_size[1] >= 1300){ //如果圖片寬高度 >=60 就顯示該圖片寬高 拿出時陣列 索引0 = width  索引1 = height 索引2 = type 索引3(attr) = html 的 weight height 
                        header("Refresh:5; url = ./card");  //php 跳轉頁面  Refresh:幾秒 url 重新導向 相對位置  
                        return "檔案格式錯誤 "."寬:" . $img_size[0] . " 高: ". $img_size[1];
                        dd( ( "寬:" . $Img_Size[0] . " 高: ". $Img_Size[1]) ); // . =字串相加
                }
                $filetype = $file->getMimeType(); //檔案種類
                $unique_name = md5($filename. time()).'.jpeg'; //隨機名字 跟著時間
                if($filetype =='image/jpeg'){ //檔案不符合時
                    $user = Auth::user(); //認證過的使用者
                    $user = auth()->user(); //認證過的使用者
                    // $user->update( ['img_path' => $destinationPath.$unique_name ] );   //更新user img路徑欄位  + 照片檔名
                    Personal::create( //存到 資料表
                            [ //上傳圖片後 用index方式 裡面用get 撈出資料 再用for each 把資料拿出
                                'user_id' => $user->id, //第幾個使用者
                                'name' => $unique_name, // 檔案名字
                                'path' => $CardPath //相對路徑 + 檔案名字
                            ]
                    );
                }else{ //檔案不符合時
                    header("Refresh:5; url = ./card");  //php 跳轉頁面  Refresh:幾秒 url 重新導向 相對位置
                    return "檔案格式錯誤";
                }       
                // dd($img_size);
                // dd($unique_name); //test
                $file->move($CardPath, $unique_name); //搬移到的資料夾,檔案名
                $i++; //計算有幾個照片被丟入 算陣列
            }
            
        }    
        
        return redirect()->route('personal.card'); //重新導向 get方式傳送資料
       
       
    }
   
}
