<?php

use app\helpers\Buttons;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\RegionsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Регионы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="regions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <p>
        <?= Html::a('Добавить Регион', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered'],
        'rowOptions'=> fn($model) => $model::giveStatus($model),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'name',
                'value' => 'name.ru'
            ],
            [
                'header'=>'Действия',
                'format' => 'html',
                'headerOptions' => ['width' => '150'],
                'content'=> static fn($model) => Buttons::get($model)
            ],
        ],
        'pager' => [
            'class' => '\yii\bootstrap5\LinkPager',
        ],
    ]); ?>


</div>
