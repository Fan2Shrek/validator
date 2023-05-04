<?php

namespace App\Validator\Interface;

use App\Validator\Validator;

interface ValidatorAwareInterface
{
    public function setValidator(Validator $validator);
}
