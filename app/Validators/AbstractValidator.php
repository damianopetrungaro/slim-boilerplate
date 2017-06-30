<?php

declare(strict_types=1);

namespace App\Validators;

use Illuminate\Database\Capsule\Manager as DB;
use Valitron\Validator;

abstract class AbstractValidator
{
    /**
     * @var Validator
     */
    protected $validator;

    /**
     * AbstractValidator constructor.
     *
     * @param Validator $validator
     */
    public function __construct(Validator $validator)
    {
        $this->addCustomRules();
        $this->validator = $validator;
    }

    /**
     * Add custom rules to the validator
     *
     * @return void
     */
    private function addCustomRules()
    {
        Validator::addRule('unique', function ($field, $value, array $params, $fields) {
            foreach ($params[0] as $table => $column) {
                if (DB::table($table)->where($column, '=', $value)->count()) {
                    return false;
                }
            }
            return true;
        }, 'must be unique in our database');

        Validator::addRule('exists', function ($field, $value, array $params, $fields) {
            foreach ($params[0] as $table => $column) {
                if (!DB::table($table)->where($column, '=', $value)->count()) {
                    return false;
                }
            }
            return true;
        }, 'must exists in our database');
    }

    /**
     * Return the list of errors
     *
     * @return array|null
     */
    public function errors():?array
    {
        $errors = $this->validator->errors();

        if (is_array($errors)) {
            return $errors;
        }

        return null;
    }

    /**
     * Validate and return true id valid, otherwise false
     *
     * @return bool
     */
    public function validate(): bool
    {
        foreach ($this->rules() as $rule) {
            $args = array_splice($rule, 0, count($rule), true);
            call_user_func_array([$this->validator, 'rule'], $args);
        }

        return $this->validator->validate();
    }

    /**
     * Array of rules
     *
     * @return array
     */
    abstract public function rules(): array;
}
