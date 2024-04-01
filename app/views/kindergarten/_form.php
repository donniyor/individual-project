<?php

use app\helpers\Data;
use app\helpers\Image;
use yii\bootstrap5\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Kindergartens $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="kindergartens-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <hr>

    <div class="mb-3">
        <?= $form->field($model, 'pay_external_service_id')->textInput() ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'pay_client_id')->textInput() ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'personal_account')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'tin')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="mb-3">
        <?= Tabs::widget(['items' => Data::generateSeveralTabs($model, ['name'], [], ['address']), 'options' => ['class' => 'mb-3']]) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'property')->dropDownList($model->getPropertyList(), ['prompt' => '']) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'images')->fileInput(['class' => 'form-control']) ?>
        <?php if (!$model->isNewRecord && empty($model->image)) { ?>
            <div class="mt-3">
                <?= Image::make($model->images)?>
            </div>
        <?php } ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'region_id')->dropDownList($model->getRegionsList()) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'status')->dropDownList($model->getStatusList()) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
