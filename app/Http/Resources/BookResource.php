<?php

namespace App\Http\Resources;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property Book $resource */
class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'author' => $this->whenNotNull($this->resource->author),
            'year' => $this->whenNotNull($this->resource->year),
            'publisher' => $this->whenNotNull($this->resource->publisher),
            'status' => $this->resource->status->value,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
        ];
    }
}
