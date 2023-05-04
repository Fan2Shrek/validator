<?php

namespace App\Validator;

use App\Validator\Interface\ValidatorInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Constraint
{
    private string $validator;

    private ?string $message = null;

    private ?array $ctx = null;

    private bool $canBeBlank;

    public function __construct(string $validator, ?string $message = null, array $ctx = [], bool $canBeBlank = false)
    {
        $this->validator = $validator;
        $this->message = $message ?? 'This cannot be empty';
        $this->ctx = $ctx;
        $this->canBeBlank = $canBeBlank;
    }

    /**
     * Get the value of validator
     */
    public function getValidator(): string
    {
        return $this->validator;
    }

    /**
     * Get the value of message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get the value of context
     */
    public function getContext()
    {
        return $this->ctx;
    }

    /**
     * Get the value of canBeBlank
     */
    public function canBeBlank(): bool
    {
        return $this->canBeBlank;
    }
}
