<?php

declare(strict_types=1);

namespace Framework;

use Framework\Contracts\RuleInterface;
use Framework\Exceptions\ValidationException;

class Validator
{
    private array $rules = [];

    public function add(string $alias, RuleInterface $rule)
    {
        // alias is going to store the id
        // not all the form have same thing to validate 
        // for ex not every form will validate credit card numbers

        // for rule parameter
        //we dont want to add rules unless they implement the contract 
        // this allows any class to passed any method
        // we are not asking a specific class but class to implement this interface

        $this->rules[$alias] = $rule;
        // dd($this->rules);
    }
    public function validate(array $formData, array $fields)
    {
        $errors = [];

        foreach ($fields as $fieldName => $rules) {
            foreach ($rules as $rule) {
                $ruleParams = [];

                if (str_contains($rule, ':')) {
                    // min:18
                    [$rule, $ruleParams] = explode(':', $rule);
                    // min,18
                    $ruleParams = explode(',', $ruleParams);
                    //18 in rule params as array
                }

                $ruleValidator = $this->rules[$rule];

                if ($ruleValidator->validate($formData, $fieldName, $ruleParams)) {
                    continue;
                }
                $errors[$fieldName][] = $ruleValidator->getMessage($formData, $fieldName, $ruleParams);
            }
        }
        if (count($errors)) {
            throw new ValidationException($errors);
        }
    }

    // public function getMessage(array $formData, string $field, array $params): string
    // {
    // }
}
