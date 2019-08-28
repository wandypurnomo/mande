<?php namespace App\Interfaces;

interface ConstantInterface
{
    public static function labels(): array;

    public static function label(int $id): String;
}