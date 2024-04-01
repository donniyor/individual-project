<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Feedbacks $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Обратная Связь', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="feedbacks-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-bordered'],
        'attributes' => [
            'id',
            [
                'attribute' => 'user_id',
                'value' => $model->user->name
            ],
            [
                'attribute' => 'kindergarten_id',
                'value' => $model->kindergarten->name['ru'] ?? '(не задано)'
            ],
            [
                'attribute' => 'images',
                'value' => $model->getAllImages($model),
                'format' => 'html'
            ],
            'phone',
            'subject',
            'message:ntext',
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
