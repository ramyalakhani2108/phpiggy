<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Validator;
use Framework\Rules\{DateFormatRule, RequiredRule, EmailRule, MinRule, InRule, MatchRule, PassRule, UrlRule, LengthMaxRule, NumericRule};

class ValidatorService
{
    private Validator $validator;
    public function __construct()
    {
        $this->validator = new Validator();
        $this->validator->add('required', new RequiredRule());
        $this->validator->add('email', new EmailRule());
        $this->validator->add('min', new MinRule());
        $this->validator->add('in', new InRule());
        $this->validator->add('url', new UrlRule());
        $this->validator->add('match', new MatchRule());
        $this->validator->add('password', new PassRule());
        $this->validator->add('lengthmax', new LengthMaxRule());
        $this->validator->add('numeric', new NumericRule());
        $this->validator->add('dateformat', new DateFormatRule());
    }

    public function validateRegister(array $formData)
    {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'age' => ['required', 'min:18'], //adding custom parameters to rule
            'country' => ['required', 'in:USA,Canada,Maxico'],
            'socialMediaURL' => ['required', 'url'],
            'password' => ['required', 'password'],
            'confirmPassowrd' => ['required', 'match:password'],
            'tos' => ['required'],

        ]);
    }

    public function validateLogin(array $formData)
    {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'password' => ['required', 'password']
        ]);
    }

    public function validateTransaction(array $formData)
    {
        $this->validator->validate($formData, [
            'description' => ['required', 'lengthmax:255'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'dateformat:Y-m-d']
        ]);
    }

    public function validateProfile(array $formData)
    {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'income' => ['required', 'numeric'],
            'country' => ['required', 'in:USA,Canada,Maxico'],
            'socialMediaURL' => ['required', 'url'],
            'username' => ['required'],
            'age' => ['required', 'min:18'], //adding custom parameters to rule




        ]);
    }
}
