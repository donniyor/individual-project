<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Kindergartens $model */

$this->title = 'Редактировать Детский сад: ' . $model->name['ru'] ?? 'Детский сад';
$this->params['breadcrumbs'][] = ['label' => 'Детские Сады', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="kindergarten-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
