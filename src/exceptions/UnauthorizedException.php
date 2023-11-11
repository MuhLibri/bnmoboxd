<?php

namespace app\exceptions;

class UnauthorizedException extends BaseException
{
    public function __construct($isView = false, $data = [])
    {
        parent::__construct(401, "Unauthorized", $isView, $data);
    }
}