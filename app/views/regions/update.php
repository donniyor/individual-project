<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Regions $model */

$this->title = 'Редактировать Регион: ' . $model->name['ru'];
$this->params['breadcrumbs'][] = ['label' => 'Регионы', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="regions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
