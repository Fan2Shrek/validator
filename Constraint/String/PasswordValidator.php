<?php

namespace Sruuua\Validator\Constraint\String;

use Sruuua\Validator\Constraint\AbstractConfigurableValidator;

class PasswordValidator extends AbstractConfigurableValidator
{
    public function supports(mixed $data): bool
    {
        return is_string($data);
    }

    public function validate(mixed $data): bool|array
    {
        $errors = array();

        if ($this->context['upper'] && !preg_match('/[A-Z]/', $data)) {
            $errors['upper'] = $this->context['upperMsg'];
        }

        if ($this->context['numeric'] && !preg_match('/[1-9]/', $data)) {
            $errors['numeric'] = $this->context['numericMsg'];
        }

        if ($this->context['special'] && !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $data)) {
            $errors['special'] = $this->context['specialMsg'];
        }

        if (strlen($data) < $this->context['lenght']) {
            $errors['lenght'] = $this->context['lenghtMsg'];
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
            'special' => true,
            'numeric' => true,
            'upper' => true,
            'lenght' => 12,
            'multipleMessages' => false,
            'upperMsg' => 'Password must contains an uppercase',
            'numericMsg' => 'Password must contains an digit',
            'specialMsg' => 'Password must contains an special character',
            'lenghtMsg' => 'Password must be 12 characters long',
        ];
    }
}
