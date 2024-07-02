<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;



class PassRule implements RuleInterface
{
    private array $passErrors = [];
    public function validate(array $formData, string $field, array $params): bool
    {
        $password = $formData[$field];

        if (strlen($password) < 8) {
            $this->passErrors[] = "Password must be at least 8 characters long.";
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $this->passErrors[] = "Password must contain at least one uppercase letter.";
        }
        if (!preg_match('/[a-z]/', $password)) {
            $this->passErrors[] = "Password must contain at least one lowercase letter.";
        }
        if (!preg_match('/\d/', $password)) {
            $this->passErrors[] = "Password must contain at least one digit.";
        }
        if (!preg_match('/[!@#$%^&*()-_=+{};:,<.>]/', $password)) {
            $this->passErrors[] = "Password must contain at least one special character.";
        }
        if (preg_match('/[\s]/', $password)) {
            $this->passErrors[] = "Password cannot contain spaces.";
        }
        if (strip_tags($password) !== $password) {
            $this->passErrors[] = "Password cannot contain HTML tags.";
        }

        return empty($this->passErrors);
    }

    public function getMessage(array $formData, string $field, array $params): string
    {

        $formattedErrors = array_map(function ($item) {
            return $item . "";
        }, $this->passErrors);

        // dd(implode("\n", $formattedErrors));
        return implode("", $formattedErrors);
    }
}
