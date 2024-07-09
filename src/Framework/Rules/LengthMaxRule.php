<?php

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

class LengthMaxRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        if (empty($params[0])) {
            throw new InvalidArgumentException("Maximum length not specified");
        }
        $length = (int) $params[0]; //255
        return strlen($data[$field]) < $length; //should be less than 255
    }

    public function getMessage(array $data, string $field, array $params): string
    {
        return "Exceed maximum character limit of {$params[0]} characters";
    }
}
