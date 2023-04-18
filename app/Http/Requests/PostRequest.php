<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return
        [
            /* "title" is required And Must be "English letters and numbers only , without spaces"
            */
            'title' => 'required|regex:/(^[a-zA-Z0-9]*$)/u|unique:posts',
            'body'  => 'max:1000'
        ];
    }
    public function messages()
    {
        return
        [
            'title.required' => 'Title field is required',
            'title.unique' => 'Title field is Repeated [ Must Be Unique ]',
            'title.regex' => 'Title field Must Be English letters and numbers only without spaces',
            'body.max' => 'Body field Not exceed 1000 characters'
        ];
    }
}
