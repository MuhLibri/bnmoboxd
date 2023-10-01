<?php

use app\exceptions\BadRequestException;

/**
 * @throws BadRequestException
 */
function saveFile(array $file, string $uploadDir): string {
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];

    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    $newFileName = time() . '_' . uniqid() . '.' . $fileExtension;

    $targetFile = $uploadDir . $newFileName;

    if (!move_uploaded_file($fileTmpName, $targetFile)) {
        throw new BadRequestException();
    }

    return $newFileName;
}
