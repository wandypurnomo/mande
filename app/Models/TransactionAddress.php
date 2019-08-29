<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionAddress extends Model
{
    public $incrementing = false;
    protected $guarded = ["id"];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
