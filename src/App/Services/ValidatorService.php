<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Validator;
use Framework\Rules\{RequiredRule, EmailRule, MinRule, InRule, MatchRule, PassRule, UrlRule};

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
}
