<?php

use backend\grid\ColorColumn;
use core\Entity\Apple;
use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AppleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Яблоки';
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\AppleAsset::register($this);
?>
<div class="apple-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?php //= Html::a('Create Apple', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Сгенерировать яблочки', ['generate'], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => SerialColumn::class],
            ['class' => ColorColumn::class],
            'birth_date:datetime',
            'fall_date:datetime',
            'size',
            'statusName:text:Статус',

            [
                'class' => ActionColumn::class,
                'template' => '{eat} {fall} {delete}',
                'buttons' => [
                    'eat' => static function ($url, Apple $model, $key) {
                        return Html::a('Съесть', '#eat', ['class' => 'btn btn-xs btn-success', 'data-btn-eat' => $model->id]);
                    },
                    'fall' => static function ($url, Apple $model, $key) {
                        return Html::a('Упасть', $url, ['class' => 'btn btn-xs btn-primary', 'data-method' => 'post']);
                    },
                    'delete' => static function ($url, Apple $model, $key) {
                        return Html::a(
                            Html::tag('i', '', ['class' => 'glyphicon glyphicon-trash']),
                            $url,
                            ['class' => 'btn btn-xs btn-danger', 'data-method' => 'post']
                        );
                    }
                ],
            ],
        ],
    ]) ?>
</div>

<div id="popover-template" class="hidden">
    <form action="<?= \yii\helpers\Url::to(['/apple/eat']) ?>" method="post" class="form-inline apple-eat-form">
        <input type="hidden" name="appleId">
        <label>Процент:</label>
        <input type="number" name="eatPercent" class="form-control" style="width:100px;padding:2px" max="100" min="1">
        <button type="submit" class="btn btn-xs btn-success">OK</button>
    </form>
</div>
