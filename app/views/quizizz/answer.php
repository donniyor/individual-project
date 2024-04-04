<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AnswerOptions $answer */
/** @var yii\widgets\ActiveForm $form */
/** @var $id */
?>

<div class="answer-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="mb-3 ml-5">
        <?= $form->field($answer, 'answer')->textarea(['maxlength' => true]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
