<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Quizizz $quiz */
/** @var app\models\Questions $question */
/** @var app\models\AnswerOptions $answer */
/** @var $id */

$this->title = 'Добавить вопросы';
$this->params['breadcrumbs'][] = ['label' => 'Опросы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quizizz-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <?php $form = ActiveForm::begin(); ?>

    <?php foreach ($quiz->questions as $question){ ?>

        <div class="mb-3">
            <?= $form->field($question, 'question')
                ->textarea([
                    'maxlength' => true,
                    'class' => 'form-control input-save',
                    'data-url' => Url::to('/quizizz/save-question'),
                    'data-quiz_id' => $question->quiz_id,
                    'data-id' => $question->id
                ]) ?>
        </div>

        <div class="push-question">
            <div class="make-answer">
               <!-- <?php /*foreach ($question->answerOptions as $answer){ */?>
                    <div class="mb-3 ml-5">
                        <?php /*= $form->field($answer->answer, 'answer')->textInput(['maxlength' => true]) */?>
                    </div>
                --><?php /*} */?>
            </div>

            <div class="mb-3">
                <?= Html::a('Добавить ответ', Url::to(['answer', 'id' => $id]), ['class' => 'btn btn-success btn-sm ajax-add-answer']) ?>
            </div>
        </div>

    <?php } ?>


    <?php ActiveForm::end(); ?>


    <div class="make-question">
    </div>

    <?= Html::a('Добавить вопрос', Url::to(['question', 'id' => $id]), ['class' => 'btn btn-success ajax-add-question']) ?>

</div>