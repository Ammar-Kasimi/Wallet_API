<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class transferTransactionRequest extends FormRequest
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
            //  'title' => 'required|string|max:255',
            // 'author' => 'required|string|max:255',
            // 'isbn' => 'required|string|unique:books,isbn',
            // 'published_year' => 'required|integer|min:1000|max:' . date('Y'),
            // 'category_id' => 'required|exists:categories,id'
           
            'type' => 'string|max:255',
            'amount' => 'required|decimal:0,2',
            'desc'=>'sometimes|string',
            'receiver_wallet_id'=>'required|exists:wallets,id'
            
        ];
        // 'wallet_id' => 'required|'
    }
}
