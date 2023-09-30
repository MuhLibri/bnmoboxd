<?php

namespace app\exceptions;

class NotFoundException extends BaseException
{
    public function __construct($isView = false, $data = [])
    {
        parent::__construct(404, "Not Found", $isView, $data);
    }
}