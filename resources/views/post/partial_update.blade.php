@extends('layouts.app') 

@section('content') <!-- 個人資料 -->

<html>
<head>
      <title>Laravel Ajax示例</title>
      <meta name="_token" content="{{ csrf_token() }}"/> <!-- 可以post -->
      
   </head>
   
   <body>


   快速查詢:<input type="text" id="fast_search" onkeyup="foucs()"> 
   <!-- <button id="test"  >x </button> -->
   <div id="all_title">
      @foreach ($timely as $key => $times) <!-- 陣列型態共6個  -->
      <div name="post_title" class="card text-center">
      {{$times }}
      </div>
      @endforeach
   
   </div>


   <script> //js 寫即時更新
   var i;
   var every_title = []; //文章集合 
   var text = []; //替換陣列
   var replace;
//    replace = document.getElementById("fast_search").value; //拿當前的輸入的值
//    document.addEventListener("onkeyup",function(){
//       // console.log(replace);
//    }) //加事件
      var xmlhttp;
      if (window.XMLHttpRequest)
      { // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
      // alert('OK');
      console.log(xmlhttp);
      }
      else
      { // code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      alert('不支援');
      }
      every_title = document.getElementsByName("post_title"); //name 才可以取陣列 
      // console.log(every_title);
   function foucs(){
      replace = document.getElementById("fast_search").value; //拿當前的輸入的值
      console.log(" 現在目前輸入: "+replace);
      every_title.forEach(function (value) { //迭代 value = 全部拿到的every_title
      // console.log(value);
            // console.log(value.textContent.trim().length);  //去除空白的所有文字    所有字串長度
            // for(var i=0;i<value.textContent.trim().length;i++){
                  // console.log("第"+i+"個"+value.textContent.trim().indexOf('a'));  //去除空白的所有文字    所有字串長度
                  // console.log(value.textContent.trim()[i]);  //去除空白的所有文字    所有單個字串長度
            // }    //value.textContent = 標頭其中的參數
            console.log(value.textContent.trim().indexOf(replace)); //去除空白後找收尋的文字 如果是有的要印出數字 -1=沒有
            if(value.textContent.trim().indexOf(replace)!=-1){ //如果沒有找到就消失
                  value.style.display = ""; //如果有的話顯示
            }else{ //沒有就消失
                  value.style.display = "none"; //如果有的話消失
            }
         
      });
  
   }

    
   </script>

   </body>
</html>
@endsection