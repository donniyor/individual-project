<?php

use app\helpers\Buttons;
use app\models\Admin;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\TransactionsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Счета';
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        'attribute' => 'prices',
        'value' => fn($model) => $model->getTotalPrices($model),
        'format' => 'html'
    ],
    [
        'attribute' => 'amount',
        'value' => 'amount',
    ],
    [
        'attribute' => 'payment_status',
        'value' => fn($model): string => $model->getPaymentStatusLabel(),
        'filter' => $searchModel->getPaymentStatus()
    ],
    [
        'attribute' => 'Дата',
        'value' => 'created_at',
        'format' => ['date', 'php:d.m.Y'],
    ],
    [
        'header' => 'Действия',
        'format' => 'html',
        'headerOptions' => ['width' => '150'],
        'content' => static fn($model) => Buttons::getView($model)
    ],
];

if (Admin::isSuperAdminStatic()) {
    array_splice($columns, 1, 0, [
        [
            'attribute' => 'kindergarten_id',
            'value' => 'kindergarten.name.ru',
            'filter' => $searchModel->getKindergartensList(),
        ]
    ]);
}

?>

<div class="transactions-index">
    <div class="row">
        <div class="col-6">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-6 d-flex align-items-center justify-content-end">
            <?= Html::a('Exel', Url::to([Yii::$app->controller->id . '/export', 'start' => $searchModel->start, 'end' => $searchModel->end]), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <hr>

    <?= $this->render('_search', ['model' => $searchModel]) ?>

    <div class="mb-3">
        <h2>График</h2>

        <div class="d-none">
            <?php foreach ($searchModel->getTransactionAmount() as $amount) { ?>
                <div class="amount"><?= $amount['amount'] ?></div>
                <div class="created_at"><?= $amount['created_at'] ?></div>
            <?php } ?>
        </div>

        <div>
            <canvas id="myChart"></canvas>
        </div>
    </div>

    <h2>Таблица</h2>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered'],
        'rowOptions' => fn($model) => $model::giveStatus($model),
        'columns' => $columns,
        'pager' => [
            'class' => '\yii\bootstrap5\LinkPager',
        ],
    ]) ?>


</div>