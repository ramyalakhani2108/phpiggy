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

    public function update(array $formData, int $id)
    {
        $formattedDate = "{$formData['date']} 00:00:00";
        $query = "UPDATE transactions SET tran_description=:desc,tran_amount=:amt,tran_date=:date WHERE tran_id=:id AND user_id=:user_id";
        $this->db->query($query, [
            'id' => $id,
            'user_id' => $_SESSION['user_id'],
            'desc' => $formData['description'],
            'amt' => $formData['amount'],
            'date' => $formattedDate
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
