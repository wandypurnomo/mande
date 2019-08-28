<?php namespace App\Constants;

use App\Interfaces\ConstantInterface;

class StockType implements ConstantInterface{

    const STOCK = 1;
    const ADJUSTMENT = 2;

    public static function labels(): array
    {
        return [
            self::STOCK => "Stock",
            self::ADJUSTMENT => "Adjustment"
        ];
    }

    public static function label(int $id): String
    {
        return array_search($id,array_flip(self::labels()));
    }
}