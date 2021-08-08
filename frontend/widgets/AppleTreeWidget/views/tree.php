<?php

/* @var $this yii\web\View */
/* @var $appleItems array */

use core\Enum\AppleStatus;
use yii\helpers\ArrayHelper;

//var_dump($appleItems);
?>
<div class="apple-tree-container">
    <div class="tree">
        <img src="/img/tree.jpeg" class="tree-image">
        <div class="apples-on-tree">
            <?php foreach ($appleItems[AppleStatus::ON_TREE] as $apple): ?>
                <?= $apple ?>
            <?php endforeach; ?>
        </div>
        <div class="apples-on-ground">
            <?php foreach (ArrayHelper::merge($appleItems[AppleStatus::ON_GROUND], $appleItems[AppleStatus::ROTTEN]) as $apple): ?>
                <?= $apple ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
