<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
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
            'name' => $this->name,
            'currency' => $this->currency,
            'balance' => round($this->balance,2),
            // 'category' => new CategoryResource(
            //     $this->whenLoaded('category')
            // ),
            'transactions' => TransactionResource::collection(
                $this->whenLoaded('transactions')
            ),
            // 'created_at' => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}
