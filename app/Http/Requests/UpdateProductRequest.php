<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
           'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'price'          => 'required|numeric|min:0', // đảm bảo giá không âm
            'import_price'   => 'nullable|numeric|min:0', // giá nhập không âm
            'discount_price' => 'nullable|numeric|min:0|lte:price', // giá khuyến mãi không lớn hơn giá gốc
            'quantity'       => 'required|integer|min:0',
            'status'         => 'required|string|in:1,2',
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // ảnh có thể không bắt buộc
         ];
    }
}
