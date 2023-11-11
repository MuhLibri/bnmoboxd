<?php

namespace app\exceptions;

class ForbiddenException extends BaseException
{
    public function __construct($isView = false, $data = [])
    {
        parent::__construct(403, "Forbidden", $isView, $data);
    }
}