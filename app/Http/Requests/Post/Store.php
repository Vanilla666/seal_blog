<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
// 驗證logic 抽離 封裝成獨立的類別
class Store extends FormRequest 
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // 可以驗證
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() //規則 
    {
        return [
            'title' => 'required', //  title 這個欄位是 validation required的驗證
            'content' => 'required' // content 這個欄位是 validation required的驗證
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '請輸入文章標題',
            'content.required' => '請輸入文章內容'
        ];
    }
}
