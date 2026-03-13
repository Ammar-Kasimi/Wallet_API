<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
           
          
            'amount' => 'required|decimal:0,2',
            'desc'=>'sometimes|string',
            // 'wallet_id'=>'sometimes'
            
        ];
        // 'wallet_id' => 'required|exists:wallets,id'
    }
}
