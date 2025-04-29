<?php

namespace App\Http\Requests;

use App\Rules\ProductQuantityAvailable;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
                new ProductQuantityAvailable($this->input('items.*.product_id')),
            ],
        ];
    }
}