<?php

namespace Sruuua\Validator\Interface;

use Sruuua\Validator\Validator;

interface ValidatorAwareInterface
{
    public function setValidator(Validator $validator);
}
