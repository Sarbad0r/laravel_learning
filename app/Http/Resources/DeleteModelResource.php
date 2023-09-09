<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeleteModelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        //if you want to get models with specify columns
        //just create resources for it
        //first run "php artisan make:resource YourModelResource"

        //write columns that you want to get
        return [
            'id' => (int)$this->id,
            'user_id' => $this->user_id,
            'user_name' => $this->user_name ?? null
        ];
    }
}
