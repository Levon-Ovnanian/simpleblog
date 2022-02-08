<?php

namespace MyProject\Services;

use MyProject\Exceptions\UploadException;
use MyProject\Models\Users\User;

class Uploads
{
    public static function UploadIcon(array $fileAttachment, User $user): ?string
    {
        $file = $_FILES['attachment'];
        $srcFileName = $file['name'];
        $newFilePath = __DIR__ . '/../../../www/uploads/profile_images/' . $user->getNickname() . '_' . $user->getEmail() . '/';
        $newFileName = $newFilePath . $srcFileName;
        $allowedExtensions = ['jpg', 'png', 'gif','jpeg'];
        $extension = pathinfo($srcFileName, PATHINFO_EXTENSION);
        if ($file['error'] === 4) {
            throw new UploadException('Вы не выбрали файл');
        }
        if (!in_array($extension, $allowedExtensions)) {
            throw new UploadException('Загрузка файлов с таким расширением запрещена!');
        }
        if ($file['size'] > 1048576) {
            throw new UploadException('Загрузка файлов весом свыше 1mb запрещена!');
        }
        if (!file_exists($newFilePath)) {
            mkdir($newFilePath);
        } else {
            $fileToDelete = glob($newFilePath . '*');
            foreach($fileToDelete as $files){
                if (is_file($files)) {
                    unlink($files);
                }
            }
        }
        
        if (!move_uploaded_file($file['tmp_name'], $newFileName)) {
            throw new UploadException('Ошибка при загрузке файла');
        }
        return  $user->getNickname() . '_' . $user->getEmail() . '/' . $srcFileName;   
    }
}