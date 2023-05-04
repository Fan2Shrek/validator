<?php

namespace Sruuua\Validator;

use Sruuua\Validator\Exception\SetterNotFoundException;
use Sruuua\Validator\Exception\ValidatorNotFoundException;
use Sruuua\Validator\Interface\ValidatorAwareInterface;
use Sruuua\Validator\Interface\ValidatorConfigurableInterface;
use Sruuua\Validator\Interface\ValidatorInterface;
use Sruuua\DependencyInjection\Container;

class Validator
{
    /**
     * @var ValidatorInterface[]
     */
    private array $validators;

    private Container $container;

    public function __construct(Container $container)
    {
        $this->validators = array();

        $this->container = $container;

        foreach ($this->container->getAllByType(ValidatorInterface::class) as $validator) {
            $this->addValidator($validator);
        }
    }

    public function addValidator(ValidatorInterface $validator)
    {
        if ($validator instanceof ValidatorAwareInterface) {
            $validator->setValidator($this);
        }

        $this->validators[$validator::class] = $validator;
    }

    public function validate(object $data): array
    {
        $return = array();
        $class = new \ReflectionClass($data::class);

        foreach ($class->getProperties() as $property) {
            $attribute = $property->getAttributes();
            if (!empty($attribute)) {
                $constraint = $attribute[0]->newInstance();

                $getter = 'get' . ucfirst($property->getName());

                if (!$class->hasMethod($getter)) {
                    throw new SetterNotFoundException(sprintf('Getter for %s not found you should create method %s()', $property->getName(), $getter));
                }

                $validator = $this->getValidator($constraint->getValidator());

                if ($validator instanceof ValidatorConfigurableInterface) {
                    $validator->configure($constraint->getContext());
                }

                $value = $data->$getter();

                $value = $this->trim($value);

                if (!$constraint->canBeBlank() && $value === "") {
                    $return[$property->getName()] = $constraint->getMessage();
                } elseif ($constraint->canBeBlank() && $value === "") {
                    continue;
                }

                if (isset($constraint->getContext()['multipleMessages']) && $constraint->getContext()['multipleMessages']) {
                    $validation = $validator->validate($value);
                    if (is_array($validation)) {
                        $return[$property->getName()] = $validation;
                    }

                    continue;
                }

                if (!$validator->validate($value)) {
                    $return[$property->getName()] = $constraint->getMessage();
                }
            }
        }

        return $return;
    }

    public function hasValidator(string $validatorName): bool
    {
        return in_array($validatorName, $this->validators);
    }

    public function getValidator(string $validatorName): ValidatorInterface
    {
        return $this->validators[$validatorName];
    }

    public function trim(string $value)
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);

        return $value;
    }
}
