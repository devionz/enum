<?php

namespace Devionz\Enum;

use ReflectionClass;
use InvalidArgumentException;

abstract class Enum implements EnumInterface
{
    /**
     * Name of defined constant.
     *
     * @var string
     */
    private $name;

    /**
     * Value assigned to constant.
     *
     * @var string|int
     */
    private $value;

    /**
     * Instantiated enums.
     * 
     * @var array<string,static>
     */
    private static $instances = [];

    /**
     * Array of enums constants.
     *
     * @var array<string,array<string,string|int>>
     */
    private static $constants = [];

    /**
     * @param string $name
     * @param string|int $value
     */
    final private function __construct(string $name, $value)
    {
        $this->name  = $name;
        $this->value = $value;
    }

    /**
     * Create enum from value.
     *
     * @param string|int $value
     * @return static
     * 
     * @throws InvalidArgumentException
     */
    final public static function from($value)
    {
        $option = array_search($value, static::toArray(), true);

        if (false !== $option) {
            return self::__callStatic($option);
        }

        throw new InvalidArgumentException("Invalid enumeration value $value");
    }

    /**
     * Create enum instance without throwing exception on invalid value. 
     * 
     * @param string|int $value
     * @return static|null
     */
    final public static function tryFrom($value)
    {
        try {
            return self::from($value);
        } catch (InvalidArgumentException $e) {
            // ...
        }
    }

    /**
     * Return array with all enum cases.
     *
     * @return array<static>
     */
    public static function cases(): array
    {
        $cases = [];

        foreach (static::toArray() as $name => $value) {
            $cases[] = self::create($name, $value);
        }

        return $cases;
    }

    /**
     * Get array of class constants.
     *
     * @return array<string,string|int>
     */
    final private static function toArray(): array
    {
        if (isset(self::$constants[static::class])) {
            return self::$constants[static::class];
        }

        $reflection = new ReflectionClass(static::class);

        return self::$constants[static::class] = $reflection->getConstants();
    }

    /**
     * Get enum instance.
     *
     * @param string $name
     * @param string|int $value
     * @return static
     */
    final private static function create($name, $value)
    {
        $key = static::class . "::{$name}";

        return self::$instances[$key] ?? self::$instances[$key] = new static($name, $value);
    }

    /**
     * @param string $name
     * @param array<mixed> $arguments
     * @return static
     * 
     * @throws InvalidArgumentException
     */
    final public static function __callStatic(string $name, array $arguments = [])
    {
        if (false === array_key_exists($name, $constants = static::toArray())) {
            throw new InvalidArgumentException("Invalid enumeration value: $name");
        }

        return self::create($name, $constants[$name]);
    }


    /**
     * @param string $name
     * @return string|int|null
     */
    final public function __get($name)
    {
        switch ($name) {
            case 'name' : return $this->name;
            case 'value': return $this->value;
        }

        trigger_error("Undefined property: ${$name}", E_USER_WARNING);
    }
}
