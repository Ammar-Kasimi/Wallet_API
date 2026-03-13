<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'type',
        'amount',
        'desc','wallet_id'
    ];
    public function wallet():BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
