<?php

namespace app\core;

abstract class Middleware
{
    public abstract function execute($isView = false);

}