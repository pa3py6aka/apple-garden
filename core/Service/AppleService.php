<?php

namespace core\Service;


use core\Factory\AppleFactory;
use core\Repository\AppleRepository;

class AppleService
{
    private AppleRepository $appleRepository;
    private TransactionManager $transaction;

    public function __construct()
    {
        $this->appleRepository = new AppleRepository();
        $this->transaction = new TransactionManager();
    }

    /**
     * Generates a random number of apples
     * @throws \Exception
     */
    public function generate(): int
    {
        $this->appleRepository->deleteAll();

        $quantity = random_int(5, 100);
        $this->transaction->wrap(function () use ($quantity) {
            for ($i = 0; $i < $quantity; $i++) {
                $color = sprintf('#%06X', random_int(0, 0xFFFFFF));

                $dateFrom = new \DateTime('-3 months');
                $birthDate = random_int($dateFrom->getTimestamp(), time());

                $apple = AppleFactory::create($color, $birthDate);
                $this->appleRepository->save($apple);
            }
        });

        return $quantity;
    }
}
