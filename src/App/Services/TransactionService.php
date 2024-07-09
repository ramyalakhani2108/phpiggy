<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;


class TransactionService
{
    public function __construct(private Database $db)
    {
    }
    public function create(array $formData)
    {

        $formattedDate = "{$formData['date']} 00:00:00"; //we don't matter time it's just because database follows this format
        $query = "INSERT INTO transactions (user_id,tran_description,tran_amount,tran_date) VALUES(:user_id,:desc,:amt,:date)";
        $this->db->query($query, [
            'user_id' => $_SESSION['user_id'],
            'desc' => $formData['description'],
            'amt' => $formData['amount'],
            'date' => $formattedDate
        ]);
    }

    public function getUserTransactions(int $length, int $offset)
    {
        $searchTerm = addcslashes($_GET['s'] ?? '', '%_'); //esacping character to treat it as a character 
        $params = [
            'user_id' => $_SESSION['user_id'],
            'desc' => "%{$searchTerm}%"
        ];
        $query = "SELECT *,DATE_FORMAT(tran_date,'%Y-%m-%d') as fomatted_date FROM transactions WHERE user_id = :user_id AND tran_description LIKE :desc LIMIT {$length} OFFSET {$offset}";

        $transactions = $this->db->query(
            $query,
            $params
        )->findAll();


        $transactions = array_map(function (array $transaction) {
            $transaction['receipts'] = $this->db->query(
                "SELECT * FROM receipts WHERE tran_id=:tran_id",
                [
                    'tran_id' => $transaction['tran_id']
                ]
            )->findAll();
            return $transaction;
        }, $transactions);

        $query = "SELECT  COUNT(*) as fomatted_date FROM transactions WHERE user_id = :user_id AND tran_description LIKE :desc";

        $transactionCount = $this->db->query($query, $params)->count();


        return [$transactions, $transactionCount];
    }

    public function getUserTransaction(string $id)
    {

        $query = "SELECT *,DATE_FORMAT(tran_date,'%Y-%m-%d') as formatted_date FROM transactions WHERE tran_id = :id and user_id = :user_id";
        return $this->db->query($query, [
            'id' => $id,
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
}
