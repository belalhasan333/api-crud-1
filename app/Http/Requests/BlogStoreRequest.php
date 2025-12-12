<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Store → POST
        if ($this->isMethod('post')) {
            return [
                'title' => 'required|string|max:258',
                'subtitle' => 'required|string|max:258',
                'description' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'price' => 'required|numeric'
            ];
        }

        // Update → PUT/PATCH
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'title' => 'required|string|max:258',
                'subtitle' => 'required|string|max:258',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'price' => 'required|numeric'
            ];
        }

        return [];
    }

    public function messages()
    {
        return [
            'title.required' => 'title is required!',
            'subtitle.required' => 'subtitle is required!',
            'description.required' => 'description is required!',
            'image.required' => 'image is required!',
            'price.required' => 'price is required!'
        ];
    }
}
