<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\ProfileService;
use App\Services\UserService;
use App\Services\ValidatorService;
use Framework\TemplateEngine;

class ProfileController
{


    public function __construct(
        private TemplateEngine $view,
        private ProfileService $profileService,
        private ValidatorService $validatorService,
        private UserService $userService
    ) {
        // $this->view = new TemplateEngine(Paths::VIEW);
    }

    public function profileView(array $params)
    {


        $userProfile = $this->profileService->getUserProfile((int)$params['user']);

        if (!$userProfile) {

            redirectTo("/");
        }

        $getTotalTransaction = $this->profileService->getTransactions($userProfile['user_id']);
        echo $this->view->render('profile.php', [
            'profile' => $userProfile,
            'total_amt' => $getTotalTransaction
        ]);
    }

    // public function edit(array $params)
    // {

    //     $transaction = $this->transactionService->getUserTransaction((string)$params['transaction']);

    //     if (!$transaction) {
    //         redirectTo("/");
    //     }
    //     // dd($transaction);
    //     $this->validatorService->validateTransaction($_POST);
    //     $this->transactionService->update($_POST, $transaction['tran_id']);


    //     redirectTo($_SERVER['HTTP_REFERER']);
    // }

    public function updateProfile()
    {

        $this->validatorService->validateProfile($_POST);
        $this->userService->isEmailTakenProfile($_POST['email'], $_SESSION['user_id']);
        $this->profileService->update($_POST);
        redirectTo("/");
    }
}
