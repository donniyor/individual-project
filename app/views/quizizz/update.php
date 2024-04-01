<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Quizizz $model */

$this->title = 'Update Quizizz: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Quizizzs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quizizz-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
