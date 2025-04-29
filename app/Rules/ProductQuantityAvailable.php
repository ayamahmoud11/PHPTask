<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class ProductQuantityAvailable implements ValidationRule, DataAwareRule
{
    protected $data = [];
    protected $productIds;

    public function __construct($productIds)
    {
        $this->productIds = $productIds;
    }

    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $index = explode('.', $attribute)[1];
        $productId = $this->productIds[$index] ?? null;
        
        if (!$productId) {
            $fail('Invalid product ID');
            return;
        }

        $product = Product::find($productId);
        
        if (!$product) {
            $fail('The selected product is invalid.');
            return;
        }

        if ($value > $product->quantity) {
            $fail("The quantity requested for {$product->name} exceeds available quantity.");
        }
    }
}