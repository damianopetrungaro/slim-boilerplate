<?php

namespace App\Validators;

use App\Responses\ApiResponse;
use Slim\Http\Request;
use Valitron\Validator;

abstract class AbstractValidator
{

    protected $validator;


    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }


    public function validate()
    {
        foreach ($this->rules() as $rule) {

            $args = array_splice($rule, 0, count($rule), true);
            call_user_func_array([ $this->validator, 'rule' ], $args);
        }

        return $this->validator->validate();
    }


    public function errors()
    {
        return $this->validator->errors();
    }


    abstract public function rules();

}