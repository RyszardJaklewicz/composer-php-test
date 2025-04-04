<?php

declare(strict_types=1);

namespace Rombarte\ArrayOfType;

interface ArrayOfTypeInterface extends \ArrayAccess
{
    /**
     * Set array elements type
     * @param string $type
     * @return ArrayOfTypeInterface
     */
    public function setType(string $type): ArrayOfTypeInterface;
}