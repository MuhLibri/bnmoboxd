<?php

namespace app\core;

use app\exceptions\BadRequestException;

class Service
{
    protected function validateRequired($data, $fields) {
        $errors = [];
        foreach ($fields as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                $errors[$field] = ucfirst(str_replace("_", " ", $field)) . ' is required';
            }
        }

        return $errors;
    }
    /*
     * Checks if errors exist or not, if yes, throw BadRequestException
     * */
    protected function handleValidationErrors($errors){
        if (!empty($errors)) {
            throw new BadRequestException(false, ['errors' => $errors]);
        }
    }
}