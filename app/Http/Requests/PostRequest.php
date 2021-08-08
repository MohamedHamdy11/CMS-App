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
        return [
            'title' => 'required|string|unique:posts',
            'description' => 'required|string',
            'content' => 'required|string',
            'image' => 'required|image',
            'categoryID' => 'required|numeric|exists:categories,id',
            'tags' => 'sometimes|nullable',
            'tags.*' => 'exists:tags,id'
        ];
    }
}
