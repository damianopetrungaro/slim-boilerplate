<?php

namespace App\Validators;

use Illuminate\Database\Capsule\Manager as DB;
use Valitron\Validator;

abstract class AbstractValidator
{

    protected $validator;

    abstract public function rules();

    public function __construct(Validator $validator)
    {
        $this->addCustomRules();
        $this->validator = $validator;
    }


    public function validate()
    {
        foreach ($this->rules() as $rule) {

            $args = array_splice($rule, 0, count($rule), true);
            call_user_func_array([$this->validator, 'rule'], $args);
        }

        return $this->validator->validate();
    }


    public function errors()
    {
        return $this->validator->errors();
    }

    private function addCustomRules()
    {
        Validator::addRule('unique', function ($field, $value, array $params, array $fields) {
            foreach ($params[0] as $table => $column) {
                if ($result = DB::table($table)->where($column, $value)->get()) {
                    return false;
                }
            }
            return true;
        }, " must be unique in our database");

        Validator::addRule('exists', function ($field, $value, array $params, array $fields) {
            foreach ($params[0] as $table => $column) {
                if (!$result = DB::table($table)->where($column, $value)->get()) {
                    return false;
                }
            }
            return true;
        }, " must exists in our database");
    }
}