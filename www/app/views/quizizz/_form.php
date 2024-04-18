<?php

use app\models\Users;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Quizizz $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="quizizz-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="mb-3">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    </div>

    <?= Users::isSuperAdminStatic() ? $form->field($model, 'status')->dropDownList($model->getStatusList(), ['class' => 'mb-3 form-control']) : '' ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
