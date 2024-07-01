<?php

// in this we provide a way to register rules by interface(contract)
// every application are different.some may need to validate emails
// some need to validate creditcard numbers
// i think it would make sense to provide validation for basic types of values to keep our project organized

// we are going to define a class for each value to validate 
// we will refer that claess as rules 


//how do we ensure a custom valdiator rule is compatible with our framework's validator ? 
// the answer is contracts

declare(strict_types=1);

namespace Framework\Contracts;

interface RuleInterface
{
    public function validate(array $formData, string $field, array $params): bool;
    //for handling validation logic for a single field in the parameter 

    public function getMessage(array $formData, string $field, array $params): string;
    // for sending error message (feedback) 
}
