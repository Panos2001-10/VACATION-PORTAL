<?php

namespace App\interfaces;

interface valueObjectInterface
{
    /**
     * Returns the value of the object.
     * The actual method name will be specific to the type of value object.
     */
    public function getValue(): string;
}
