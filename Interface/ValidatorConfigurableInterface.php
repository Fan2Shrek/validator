<?php

namespace App\Validator\Interface;

/**
 * @property array $ctx
 */
interface ValidatorConfigurableInterface
{
    /**
     * Set up all default value for the configuration
     */
    public function setDefault();

    public function configure(array $ctx);
}
