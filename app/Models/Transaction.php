<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $incrementing = false;
    protected $guarded = ["id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class, "transaction_id");
    }

    public function couriers()
    {
        return $this->belongsToMany(User::class, "transaction_courier", "transaction_id", "user_id");
    }

    public function address()
    {
        return $this->hasOne(TransactionAddress::class, "transaction_id");
    }
}
