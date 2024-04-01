<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Tabs;
use app\helpers\Data;

/** @var yii\web\View $this */
/** @var app\models\Regions $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="regions-form">

    <?php $form = ActiveForm::begin(); ?>
    <hr>

    <div class="mb-3">
        <?=Tabs::widget(['items' => Data::generateSeveralTabs($model, ['name']), 'options' => ['class' => 'mb-3']])?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'status')->dropDownList($model->getStatusList()) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>