<?php

use app\helpers\Buttons;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UsersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <?= $this->render('_search', ['model' => $searchModel]) ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'phone',
            'language',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d.m.Y'],
                'filterInputOptions' => ['class' => 'form-control date-changer']
            ],
            [
                'header'=>'Действия',
                'format' => 'html',
                'headerOptions' => ['width' => '150'],
                'content'=> static fn($model) => Buttons::getView($model)
            ],
        ],
        'pager' => [
            'class' => '\yii\bootstrap5\LinkPager',
        ],
    ]); ?>


</div>
