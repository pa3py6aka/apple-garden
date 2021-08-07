<?php

namespace backend\grid;

use core\Entity\Apple;
use yii\grid\DataColumn;

class ColorColumn extends DataColumn
{
    public $attribute = 'color';
    public $format = 'raw';

    public function renderDataCellContent($model, $key, $index): string
    {
        /* @var $model Apple */
        return <<<HTML
<div style="display: flex">
    <div style="height:20px;width:20px; background-color:{$model->color}; margin-right:10px; border-radius:50%">&nbsp;</div>
    <div style="flex:1">{$model->color}</div>
</div>
HTML;
    }
}
