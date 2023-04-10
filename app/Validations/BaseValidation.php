<?php

namespace App\Validations;

class BaseValidation
{
    private ?object $validation = null;

    public function __construct()
    {
        $this->validation = service('validation');
    }

    public function validate(array $rules, array $data): bool|array
    {
        $this->validation->setRules($rules);

        if (!$this->validation->run($data)) {
            return $this->validation->getErrors();
        }

        return true;
    }
}
