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
            'title.required' => 'Name is required!',
            'subtitle.required' => 'Subtitle is required!',
            'description.required' => 'Description is required!',
            'image.required' => 'Image is required!',
            'price.required' => 'Price is required!'
        ];
    }
}
