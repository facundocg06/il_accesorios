<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VarietyProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->product->name,
            'price' => $this->product->price,
            'image' => $this->product->image,
            'description' => $this->product->description,
            'category' => $this->product->category->name_category,
            'brand' => $this->product->brand->name,
            'quantity' => $this->quantity,
            'barcode' => $this->product->barcode,
        ];
    }
}
