<?php

namespace app\exceptions;

class BadRequestException extends BaseException
{
    public function __construct($isView = false, $data = [])
    {
        parent::__construct(400, "Bad Request", $isView, $data);
    }
}