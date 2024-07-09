<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;


class ProfileService
{
    public function __construct(private Database $db)
    {
    }

    public function getUserProfile(int $id)
    {

        $query = "SELECT * FROM users WHERE user_id = :user_id";
        return $this->db->query($query, [
            // 'id' => $id
            'user_id' => $_SESSION['user_id']
        ])->find();
    }

    public function update(array $formData)
    {

        $query = "UPDATE users SET user_email=:eml,user_age=:age,user_country=:ctry,user_social_media_url=:soci,income=:inc,balance=:bal,username=:un WHERE user_id=:uid";
        $this->db->query($query, [
            'eml' => $formData['email'],
            'age' => $formData['age'],
            'uid' => $_SESSION['user_id'],
            'ctry' => $formData['country'],
            'soci' => $formData['socialMediaURL'],
            'inc' => $formData['income'],
            'bal' => $formData['balance'],
            'un' => $formData['username'],
        ]);
    }


    public function delete(int $id)
    {
        $query = "DELETE FROM transactions WHERE tran_id=:id AND user_id=:user_id";
        $this->db->query($query, [
            'id' => $id,
            'user_id' => $_SESSION['user_id'],
        ]);
    }

    public function getTransactions(int $id)
    {
        $query = "SELECT SUM(tran_amount) as total_transaction FROM transactions WHERE user_id = :uid";
        $total_amt = $this->db->query($query, [
            'uid' => $id
        ])->find();
        return $total_amt;
    }
}
