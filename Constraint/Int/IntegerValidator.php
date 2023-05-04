<?php

namespace Sruuua\Validator\Constraint\Int;

use Sruuua\Validator\Constraint\AbstractConfigurableValidator;

class IntegerValidator extends AbstractConfigurableValidator
{
    public function supports(mixed $data): bool
    {
        return is_numeric($data);
    }

    public function validate(mixed $data): bool|array
    {
        $errors = array();

        if ($data < $this->context['minValue']) {
            $errors['minValue'] = $this->context['minValueMsg'];
        }

        if ($data > $this->context['maxValue']) {
            $errors['maxValue'] = $this->context['maxValueMsg'];
        }

        if (!empty($this->context['inArray']) && in_array($data, $this->context['inArray'])) {
            $errors['inArray'] = $this->context['inArrayMsg'];
        }

        if ($data % $this->context['multipleOf'] != 0) {
            $errors['multipleOf'] = $this->context['multipleOfMsg'];
        }

        if (empty($errors)) return true;

        if ($this->context['multipleMessages']) {
            return $errors;
        }

        return false;
    }

    public function setDefault()
    {
        $this->context = [
            'minValue' => 0,
            'maxValue' => 10 ** 10,
            'inArray' => [],
            'multipleOf' => 1,
            'minValueMsg' => 'The number must be > 0',
            'maxValueMsg' => 'The number is too high',
            'inArrayMsg' => 'The number needs to be equal to []',
            'multipleOfMsg' => 'The number should be multiple of 1',
            'multipleMessages' => false,
        ];
    }
}
