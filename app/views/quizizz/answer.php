<?php

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
        <?= $form->field($answer, 'answer')->textInput([
            'maxlength' => true,
            'class' => 'form-control ajax-save-answer',
            'data-url' => Url::to('/quizizz/save-answer'),
            'data-question_id' => $id,
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
