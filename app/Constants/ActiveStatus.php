<?php namespace App\Constants;

use App\Interfaces\ConstantInterface;

class ActiveStatus implements ConstantInterface {
    const ACTIVE = 1;
    const INACTIVE = 0;
    public static function labels(): array
    {
        return [
            self::ACTIVE => "Active",
            self::INACTIVE => "Inactive"
        ];
    }

    public static function label(int $id): String
    {
        return array_search($id,array_flip(self::labels()));
    }
}