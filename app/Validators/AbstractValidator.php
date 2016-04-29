<?php

namespace App\Validators;

use Valitron\Validator;

abstract class AbstractValidator
{

    protected $validator;


    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
        $this->validate();
    }


    protected function validate()
    {
        foreach ($this->rules() as $rule) {
            //@TODO: Fix the rule
            $this->validator->rule($rule);
        }

        if ( ! $this->validator->validate()) {
            var_dump($this->validator->errors());
            die();
        }

        return true;
    }


    abstract public function rules();

}