<?php

use app\helpers\Buttons;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\FeedbacksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Обратная Связь';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedbacks-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'kindergarten_id',
                'value' => 'kindergarten.name.ru',
                'filter' => $searchModel->getKindergartensList()
            ],
            'user.name',
            'phone',
            'message:ntext',
            [
                'label' => 'Фото',
                'value' => fn($model): ?string => $model->getAllImages($model),
                'format' => 'html'
            ],
            [
                'header' => 'Действия',
                'format' => 'html',
                'headerOptions' => ['width' => '150'],
                'content' => static fn($model): string => Buttons::getView($model)
            ],
        ],
        'pager' => [
            'class' => '\yii\bootstrap5\LinkPager',
        ]
    ]); ?>


</div>
