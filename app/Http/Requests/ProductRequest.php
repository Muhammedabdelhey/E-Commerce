<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            // 'images' => 'required',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'required',
            'colors.*' => 'required|exists:colors,id',
            'sizes.*' => 'required|exists:sizes,id',
            'quantities.*' => 'required|integer|min:0',
        ];
        return $rules;
    }
    // public function failedValidation(Validator $validator)
    // {
    //     $errors = $validator->errors();
    //     return redirect()->route('products.create')->withErrors($errors)->withInput();
    // }
}
