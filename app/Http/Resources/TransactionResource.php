<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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

            'wallet_id' => $this->wallet_id,
            'type' => $this->type,
            'desc' => $this->desc,
            'amount' => $this->amount,
            'wallet' => new WalletResource(
                $this->whenLoaded('wallet')
            ),
            'description'=>$this->desc,
            "balance_after"=>$this->wallet->balance,
            'created_at' => $this->created_at->format('Y-m-d H:i')

            // 'books' => BookResource::collection(
            //     $this->whenLoaded('books')
            // ),
        ];
    }
}
