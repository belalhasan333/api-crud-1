<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class BlogStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'category_id'     => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'title'           => 'required|string|max:255',
            'subtitle'        => 'required|string|max:255',
            'description'     => 'required|string',
            'price'           => 'required|numeric',
        ];

        if ($this->isMethod('post')) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,webp|max:2048';
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'category_id.required'     => 'Category is required!',
            'sub_category_id.required' => 'Sub-category is required!',
        ];
    }
}




