<?php

use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AppleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Яблоки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apple-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?php //= Html::a('Create Apple', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Generate apples', ['generate'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => SerialColumn::class],

            'id',
            'color',
            'birth_date',
            'fall_date',
            'size',
            //'status',

            ['class' => ActionColumn::class],
        ],
    ]) ?>
</div>
