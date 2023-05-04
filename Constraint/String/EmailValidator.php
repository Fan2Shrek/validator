<?php

namespace Sruuua\Validator\Constraint\String;

use Sruuua\Validator\Interface\ValidatorInterface;

class EmailValidator implements ValidatorInterface
{
    public function supports(mixed $data): bool
    {
        return is_string($data);
    }

    public function validate(mixed $data): bool
    {
        return filter_var($data, FILTER_VALIDATE_EMAIL);
    }
}
