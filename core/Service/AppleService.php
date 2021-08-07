<?php

namespace core\Service;


use core\Entity\Apple;
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

    public function eat(Apple $apple, int $percent): void
    {
        $piece = $percent / 100;
        $apple->eat($piece);
        $this->appleRepository->save($apple);
    }

    public function fall(Apple $apple): void
    {
        $apple->fallFromTree();
        $this->appleRepository->save($apple);
    }
}
