<?php

namespace frontend\widgets\AppleTreeWidget;

use core\Entity\Apple;
use core\Enum\AppleStatus;
use core\Repository\AppleRepository;
use yii\base\Widget;
use yii\helpers\Html;

class AppleTreeWidget extends Widget
{
    protected AppleRepository $appleRepository;

    public function __construct($config, AppleRepository $appleRepository)
    {
        parent::__construct($config);
        $this->appleRepository = $appleRepository;
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function run(): string
    {
        $applesOnTree = $this->appleRepository->findByCriteria([]);
        $this->view->registerAssetBundle(AppleTreeAsset::class);
        return $this->render('tree', ['appleItems' => $this->generateAppleItems($applesOnTree)]);
    }


    /**
     * @param Apple[] $apples
     */
    protected function generateAppleItems(array $apples): array
    {
        $result = [
             AppleStatus::ON_TREE => [],
             AppleStatus::ON_GROUND => [],
             AppleStatus::ROTTEN => [],
        ];

        foreach ($apples as $apple) {
            $top = random_int(0, 100);
            $left = random_int(0, 100);
            $color = $apple->getStatus() === AppleStatus::ROTTEN ? 'black' : $apple->getColor();
            $style = "background-color:{$color}; top:{$top}%; left: {$left}%";

            $result[$apple->getStatus()][] = Html::tag('div', '', [
                'class' => 'apple-item',
                'style' => $style
            ]);
        }

        return $result;
    }
}
