<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Users $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-bordered'],
        'attributes' => [
            'id',
            'name',
            'phone',
            'language',
            'telegram_chat_id',
            'status',
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
