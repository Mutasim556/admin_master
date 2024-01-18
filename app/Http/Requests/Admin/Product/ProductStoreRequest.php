<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_type' => ['required'],
            'product_name' => ['required','max:255'],
            'product_code' => ['required','integer'],
            'barcode_symbology' => ['required'],
            'category' => ['required'],
            'product_unit' => ['required'],
            'sale_unit' => ['required'],
            'purchase_unit' => ['required'],
            'unit_size' => ['required','regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'cartoon_size' => ['required','regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'product_cost' => ['required','regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'product_price' => ['required','regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'daily_sale_objective' => ['regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'alert_quantity' => ['regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'variant_option.*'=>['required_if:variant,on'],
            'variant_value.*'=>['required_if:variant,on'],
        ];
    }

    public function store(){

    }
}
