<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{ValidatorService, TransactionService};

class TransactionController
{
    public function __construct(
        private TemplateEngine $view,
        private ValidatorService $validatorService,
        private TransactionService $transactionService
    ) {
    }

    public function createView()
    {
        echo $this->view->render("transactions/create.php");
    }

    public function create()
    {
        $this->validatorService->validateTransaction($_POST);
        $this->transactionService->create($_POST);
        redirectTo("/");
    }

    public function editView(array $params)
    {
        // dd($params['transaction']);
        $transaction = $this->transactionService->getUserTransaction((string)$params['transaction']);

        if (!$transaction) {
            redirectTo("/");
        }
        echo $this->view->render('transactions/edit.php', [
            'transactions' => $transaction
        ]);
    }

    public function edit(array $params)
    {

        $transaction = $this->transactionService->getUserTransaction((string)$params['transaction']);

        if (!$transaction) {
            redirectTo("/");
        }
        // dd($transaction);
        $this->validatorService->validateTransaction($_POST);
        $this->transactionService->update($_POST, $transaction['tran_id']);


        redirectTo($_SERVER['HTTP_REFERER']);
    }


    public function delete(array $params)
    {
        // dd("hi");

        // dd($params);
        // $transaction = $this->transactionService->getUserTransaction((string)$params['transaction']);

        // if (!$transaction) {

        //     redirectTo("/");
        // }
        // dd($transaction);
        // $this->validatorService->validateTransaction($_POST);
        // dd($params['transaction']);
        $this->transactionService->delete((int)$params['transaction']);
        redirectTo("/");
    }
}
