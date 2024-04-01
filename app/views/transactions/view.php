<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Transactions $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Счета', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="transactions-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-bordered'],
        'attributes' => [
            'id',
            'uuid',
            [
                'attribute' => 'kindergarten_id',
                'value' => $model->kindergarten->name['ru'] ?? '(не задано)',
            ],
            [
                'attribute' => 'payment_status',
                'value' => $model->getPaymentStatusLabel(),
            ],
            [
                'attribute' => 'prices',
                'value' => $model->getTotalPrices($model),
                'format' => 'html'
            ],
            'processing_id',
            'gnk_fields',
            'amount',
            'user.name',
            'desc',
            'tin',
            'personal_account',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php: d.m.Y H:i:s']
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php: d.m.Y H:i:s']
            ],
        ],
    ]) ?>

</div>
