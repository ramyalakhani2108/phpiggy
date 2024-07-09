<?php

declare(strict_types=1);

namespace App\Services;

use App\Config\Paths;
use Framework\Database;
use Framework\Exceptions\ValidationException;

// use Framework\Rules\EmailRule;

class ReceiptService
{
    public function __construct(private Database $db)
    {
    }
    public function validateFile(?array $fileData)
    {

        if (!$fileData || $fileData['error'] !== UPLOAD_ERR_OK) {
            throw new ValidationException([
                'receipt' => ['Faild to upload file']
            ]);
        }
        // dd($fileData);
        $maxFileSizeMB = 3 * 1024 * 1024;

        if ($fileData['size'] > $maxFileSizeMB) {
            throw new ValidationException([
                'receipt' => ['File should be lesser than ' . ($maxFileSizeMB / 1024) / 1024 . 'MB']
            ]);
        }

        $originalFileName = $fileData['name'];

        if (!preg_match('#^[A-Za-z0-9\s\(\)._-]+#', $originalFileName)) {
            throw new ValidationException([
                'receipt' => ['Invalid file name']
            ]);
        }

        $clientMimeType = $fileData['type'];
        $allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];

        if (!in_array($clientMimeType, $allowedMimeTypes)) {
            throw new ValidationException([
                'receipt' => ['Invalid file type']
            ]);
        }
    }

    public function upload(?array $fileData, int $transaction)
    {
        $fileExt = pathinfo($fileData['name'], PATHINFO_EXTENSION);
        $newFileName = bin2hex(random_bytes(16)) . "." . $fileExt;

        $uploadPath = Paths::STORAGE_UPLOADS . "/" . $newFileName;

        if (!move_uploaded_file($fileData['tmp_name'], $uploadPath)) {
            throw new ValidationException([
                'receipt' => ['Failed To Upload Wide']
            ]);
        }
        // dd($newFileName);
        $query = "INSERT INTO receipts(tran_id,original_filename,storage_filename,media_type) VALUES(:tran_id,:original_filename,:storage_filename,:media_type)";
        $this->db->query($query, [
            'tran_id' => $transaction,
            'original_filename' => $fileData['name'],
            'storage_filename' => $newFileName,
            'media_type' => $fileData['type']
        ]);
    }

    public function getReceipt(string $id)
    {
        $query = "SELECT * FROM receipts WHERE receipt_id = :id";
        $receipt = $this->db->query($query, [
            'id' => $id
        ])->find();

        return $receipt;
    }

    public function read(array $receipt)
    {
        $filePath = Paths::STORAGE_UPLOADS . '/' . $receipt['storage_filename'] ?? '';

        if (!file_exists($filePath)) {
            redirectTo('/');
        }
        // dd($receipt);
        header("Content-Disposition: inline;filename={$receipt['original_filename']}");
        header("Content-Type: {$receipt['media_type']}");
        readfile($filePath);
        // dd($filePath);
    }

    public function delete(array $receipt)
    {
        $filePath = Paths::STORAGE_UPLOADS . '/' . $receipt['storage_filename'] ?? '';
        if (!file_exists($filePath)) {
            redirectTo('/');
        }
        unlink($filePath);


        $query = "DELETE FROM receipts WHERE receipt_id=:id";
        $this->db->query($query, [
            'id' => $receipt['receipt_id']
        ]);
    }
}
