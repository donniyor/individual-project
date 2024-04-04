<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Questions $question */
/** @var app\models\AnswerOptions $answer */
/** @var yii\widgets\ActiveForm $form */
/** @var $id */
?>

<div class="question-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="mb-3">
        <?=$form->field($question, 'quiz_id')->hiddenInput(['value' => $id])->label(false)?>
        <?= $form->field($question, 'question')->textarea(['maxlength' => true]) ?>
    </div>


    <div class="make-answer">
    </div>

    <div class="mb-3">
        <?=Html::a('Добавить ответ', Url::to(['answer', 'id' => $id]), ['class' => 'btn btn-success btn-sm ajax-add-answer'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
