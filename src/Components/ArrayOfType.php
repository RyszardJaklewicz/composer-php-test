<?php

declare(strict_types=1);

namespace Rombarte\ArrayOfType\Components;

use Rombarte\ArrayOfType\ArrayOfTypeInterface;
use Rombarte\ArrayOfType\Exceptions\UnexpectedTypeException;

class ArrayOfType implements ArrayOfTypeInterface
{
    private const ALLOWED_ELEMENTS_TYPES = [
        'bool',
        'boolean',
        'float',
        'int',
        'integer',
        'string',
    ];

    /** @var string */
    private $type;

    /** @var array */
    private $array;

    public function __construct()
    {
        $this->array = [];
    }

    /**
     * Set array elements type
     * @param string $type
     * @return ArrayOfTypeInterface
     * @throws UnexpectedTypeException
     */
    public function setType(string $type): ArrayOfTypeInterface
    {
        if (!in_array($type, self::ALLOWED_ELEMENTS_TYPES)) {
            throw new UnexpectedTypeException('Unexpected elements type: ' . $type);
        }
        $this->type = $type;
        return $this;
    }

    /**
     * Whether a offset exists
     * @param mixed $offset
     * @return boolean true on success or false on failure.
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->array[$offset]);
    }

    /**
     * Offset to retrieve
     * @param mixed $offset
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->array[$offset];
    }

    /**
     * Offset to set
     * @param mixed $offset
     * @param mixed $value
     * @return void
     * @since 5.0.0
     * @throws UnexpectedTypeException
     */
    public function offsetSet($offset, $value)
    {
        $paramType = gettype($value);
        if ($paramType !== $this->type) {
            throw new UnexpectedTypeException('Unexpected elements type: ' . $paramType);
        }
        if (empty($offset)) {
            $this->array[] = $value;
        } else {
            $this->array[$offset] = $value;
        }
    }

    /**
     * Offset to unset
     * @param mixed $offset
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->array[$offset]);
        $this->array = array_values($this->array);
    }
}