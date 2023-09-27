<?php

namespace App\Http\Requests;

use App\Rules\ArrayLengthRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            "product_ids" => 'required',
            "product_ids.*" => 'required',
            "colors" => ['required',new ArrayLengthRule('product_ids')],
            "sizes" => ['required',new ArrayLengthRule('product_ids')],
            'colors.*' => 'required|exists:colors,id',
            'sizes.*' => 'required|exists:sizes,id',
            'quantity.*'=>'required|min:1'
        ];
        return $rules;
    }
    public function messages(): array
    {
        return [
            'product_ids.required' => 'Please select at least one product.',
            'product_ids.*.exists' => 'The selected product is invalid.',
            'colors.required' => 'Please select  product color.',
            'sizes.required' => 'Please select product size.',
            'colors.*.exists' => 'The selected color is invalid.',
            'sizes.*.exists' => 'The selected size is invalid.',
        ];
    }
}
