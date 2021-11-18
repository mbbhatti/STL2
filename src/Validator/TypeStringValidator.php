<?php

namespace App\Validator;

use Valdi\Validator\ValidatorInterface;

class TypeStringValidator implements ValidatorInterface
{
    /**
     * Validates the given value.
     *
     * @param mixed $value
     * the value to validate
     *
     * @param array $parameters
     * the other parameters the validator might need
     *
     * @return boolean
     * true if the value is valid, false else
     */
    public function isValid($value, array $parameters) {
        return is_string($value);
    }

    /**
     * Gets the details if the validation failed.
     *
     * @return mixed
     * the details
     */
    public function getInvalidDetails() {
        return 'String';
    }
}

