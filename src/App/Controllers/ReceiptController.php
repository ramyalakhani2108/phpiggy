<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{TransactionService, ReceiptService, ValidatorService};

class ReceiptController
{
    public function __construct(
        private TemplateEngine $view,
        private TransactionService $transactionService,
        private ReceiptService $receiptService,
    ) {
    }

    public function uploadView(array $params)
    {
        // // dd(param)
        // dd($params);
        $transaction = $this->transactionService->getUserTransaction($params['transaction']);

        if (!$transaction) {
            redirectTo("/");
        }

        echo $this->view->render("receipts/create.php");
    }

    public function upload(array $params)
    {
        // dd($params);
        // $this->receiptService->validateFile($_FILES);
        $transaction = $this->transactionService->getUserTransaction($params['transaction']);

        if (!$transaction) {
            redirectTo("/");
        }

        $receiptFile = $_FILES['receipt'] ?? null;

        $this->receiptService->validateFile($_FILES['receipt']);
        $this->receiptService->upload($receiptFile, $transaction['tran_id']);
        redirectTo("/");
    }
    public function download(array $params)
    {
        // dd($params['receipt']);
        $transaction = $this->transactionService->getUserTransaction($params['transaction']);
        if (empty($transaction)) {
            redirectTo("/");
        }
        $receipt = $this->receiptService->getReceipt($params['receipt']);


        if (empty($receipt)) {
            redirectTo("/");
        }

        if ($receipt['tran_id'] !== $transaction['tran_id']) {
            redirectTo('/');
        }
        // dd($receipt);
        $this->receiptService->read($receipt);
    }
    public function delete(array $params)
    {
        $transaction = $this->transactionService->getUserTransaction($params['transaction']);
        if (empty($transaction)) {
            redirectTo("/");
        }
        $receipt = $this->receiptService->getReceipt($params['receipt']);


        if (empty($receipt)) {
            redirectTo("/");
        }

        if ($receipt['tran_id'] !== $transaction['tran_id']) {
            redirectTo('/');
        }
        $this->receiptService->delete($receipt);
        redirectTo('/');
    }
}
