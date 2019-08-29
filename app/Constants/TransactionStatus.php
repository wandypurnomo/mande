<?php namespace App\Constants;

use App\Interfaces\ConstantInterface;

class TransactionStatus implements ConstantInterface
{
    const CART = 0;
    const PLACED = 1;
    const ON_DELIVERY = 2;
    const DONE = 3;
    const FAILED = 4;

    public static function label(int $id): String
    {
        return array_search($id, array_flip(self::labels()));
    }

    public static function labels(): array
    {
        return [
            self::CART => "Cart",
            self::PLACED => "Placed",
            self::ON_DELIVERY => "On Delivery",
            self::DONE => "Done",
            self::FAILED => "Failed"
        ];
    }
}