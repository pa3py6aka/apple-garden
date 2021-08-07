<?php

namespace core\Service;


use core\Repository\AppleRepository;

class AppleService
{
    private AppleRepository $appleRepository;

    public function __construct()
    {
        $this->appleRepository = new AppleRepository();
    }
}
