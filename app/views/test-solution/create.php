<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TestSolution $model */

$this->title = 'Create Test Solution';
$this->params['breadcrumbs'][] = ['label' => 'Test Solutions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-solution-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
