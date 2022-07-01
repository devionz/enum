<?php

namespace Devionz\Enum;

interface EnumInterface
{
    /**
     * Create enum from value.
     *
     * @param string|int $value
     * @return static
     * 
     * @throws InvalidArgumentException
     */
    public static function from($value);

    /**
     * Create enum instance without throwing exception on invalid value. 
     *
     * @param string|int $value
     * @return static|null
     */
    public static function tryFrom($value);
}