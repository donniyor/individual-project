<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Kindergartens $model */

$this->title = 'Добавить Детский сад';
$this->params['breadcrumbs'][] = ['label' => 'Детские сады', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kindergarten-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
