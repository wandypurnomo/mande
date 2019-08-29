<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    public $incrementing = false;
    protected $guarded = ["id"];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
