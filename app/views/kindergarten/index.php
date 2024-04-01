<?php

use app\helpers\Buttons;
use app\helpers\Image;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\KindergartensSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Детские сады';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kindergarten-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <p>
        <?= Html::a('Добавить Детский Сад', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered'],
        'rowOptions'=> fn($model) => $model::giveStatus($model),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'value' => 'name.ru'
            ],
            [
                'attribute' => 'property',
                'value' => fn($model) => $model->getPropertyList()[$model->property],
                'filter' => $searchModel->getPropertyList(),
            ],
            [
                'attribute' => 'region_id',
                'value' => 'region.name.ru',
                'filter' => $searchModel->getRegionsList()
            ],
            [
                'attribute' => 'images',
                'format' => 'html',
                'value' => fn($model) => Image::make($model->images)
            ],
            [
                'header' => 'Действия',
                'format' => 'html',
                'headerOptions' => ['width' => '150'],
                'content' => static fn($model) => Buttons::get($model)
            ],
        ],
        'pager' => [
            'class' => '\yii\bootstrap5\LinkPager',
        ],
    ]); ?>


</div>
