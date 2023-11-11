<?php

namespace app\exceptions;

class InternalServerErrorException extends BaseException
{
    public function __construct($isView = false, $data = [])
    {
        parent::__construct(500, "Interval Server Error", $isView, $data);
    }
}