<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            "category_id" => "required|exists:product_categories,id",
            "name" => "required|unique",
            "description" => "required",
            "image_file" => "required|image",
            "price" => "required|numeric",
            "label_id" => "required|numeric"
        ];
    }
}
