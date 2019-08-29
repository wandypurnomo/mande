<?php namespace App\Constants;

use App\Interfaces\ConstantInterface;

class PaymentStatus implements ConstantInterface
{
    const UNPAID = 0;
    const PAID = 1;
    const EXPIRED = 2;
    const FAILED = 4;

    public static function label(int $id): String
    {
        return array_search($id, array_flip(self::labels()));
    }

    public static function labels(): array
    {
        return [
            self::UNPAID => "Unpaid",
            self::PAID => "Paid",
            self::EXPIRED => "Expired",
            self::FAILED => "Failed"
        ];
    }
}