<?php

namespace Sruuua\Validator\Constraint;

use Sruuua\Validator\Interface\ValidatorConfigurableInterface;
use Sruuua\Validator\Interface\ValidatorInterface;
use Sruuua\Validator\Exception\OptionNotExist;

abstract class AbstractConfigurableValidator implements ValidatorConfigurableInterface, ValidatorInterface
{
    protected array $context;

    public function configure(array $ctx)
    {
        $this->setDefault();
        foreach ($ctx as $option => $value) {
            if (!isset($this->context[$option])) {
                $optList = '';
                foreach ($this->context as $opt => $a) {
                    $optList .= $opt . ' ';
                }
                throw new OptionNotExist(sprintf("%s class does not have %s option.\nAvailable option are : %s", __CLASS__, $option, $optList));
            }
            $this->context[$option] = $value;
        }
    }
}
