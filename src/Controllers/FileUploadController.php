<?php

namespace App\Controllers;

class FileUploadController {
    private $uploadDir = __DIR__ . '/../../storage/portfolios/';
    private $allowedFormats = ['pdf', 'docx', 'zip', 'jpg', 'png'];
    private $maxSize = 50 * 1024 * 1024; // 50 MB

    public function uploadFile($file) {
        if ($file['size'] > $this->maxSize) {
            return ['error' => 'File size exceeds the maximum limit of 50 MB'];
        }

        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (!in_array($fileExtension, $this->allowedFormats)) {
            return ['error' => 'Invalid file format'];
        }

        $targetPath = $this->uploadDir . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return ['message' => 'File uploaded successfully', 'path' => $targetPath];
        }

        return ['error' => 'File upload failed'];
    }
}
