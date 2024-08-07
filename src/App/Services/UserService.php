<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;
use Framework\Rules\EmailRule;



class UserService
{
    public function __construct(private Database $db)
    {
    }
    public function isEmailTaken(string $email)
    {
        $query = "SELECT COUNT(*) FROM users WHERE user_email=:email";
        $emailCount = $this->db->query($query, [
            'email' => $email
        ])->count();

        if ($emailCount > 0) {
            throw new ValidationException(['email' => 'Email Taken']);
        }
    }
    public function isEmailTakenProfile(string $email, int $id)
    {
        $query = "SELECT COUNT(*) FROM users WHERE user_email=:email";
        $emailCount = $this->db->query($query, [
            'email' => $email
        ])->count();

        $query = "SELECT user_email FROM users WHERE user_email=:email";
        $emailFind = $this->db->query($query, [
            'email' => $email
        ])->find();


        if ($emailCount > 0) {
            if ($email !== $emailFind['user_email']) {
                throw new ValidationException(['email' => 'Email Taken']);
            }
        }
    }

    public function create(array $formData)
    {
        $password = password_hash($formData['password'], PASSWORD_BCRYPT, ['cost' => 12]);
        $formData['email'] = e($formData['email']);
        $query = "INSERT INTO users (username,user_email,user_pass,user_age,user_country,user_social_media_url) VALUES(:un,:email,:pass,:age,:country,:url)";
        $this->db->query($query, [
            'un' => $formData['username'],
            'email' => $formData['email'],
            'pass' => $password,
            'age' => $formData['age'],
            'country' => $formData['country'],
            'url' => $formData['socialMediaURL']
        ]);
        session_regenerate_id(); //we are going to generate a new session ID whenever the authentication status of the user changes.
        $_SESSION['user_id'] = $this->db->id();
    }

    public function login(array $formData)
    {
        $query = "SELECT * FROM users WHERE user_email=:email";

        $user = $this->db->query($query, [
            'email' => $formData['email']
        ])->find();

        $passwordsMatch = password_verify($formData['password'], $user['user_pass'] ?? '');

        if (!$user || !$passwordsMatch) {
            throw new ValidationException(['password' => ['Invalid Cradentials']]);
        }
        session_regenerate_id();

        $_SESSION['user_id'] = $user['user_id'];
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        // session_destroy(); 
        // session_regenerate_id(); //for extra precaution
        $params = session_get_cookie_params();
        setcookie(
            'PHPSESSID',
            "",
            time() - 3600, //subtracting random numbers for security
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']


        );
    }
}
