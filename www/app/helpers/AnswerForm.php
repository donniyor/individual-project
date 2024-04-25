<?php

namespace app\helpers;

use app\models\AnswerOptions;
use yii\helpers\Html;
use yii\helpers\Url;

class AnswerForm
{
    public static function renderAnswer(AnswerOptions $answerOptions, int $answerId): string
    {
        return static::generateTextareaHtml($answerOptions, $answerId);
    }

    protected static function generateTextareaHtml(AnswerOptions $answerOptions, int $answerId): string
    {
        $textareaAttributes = [
            'maxlength' => true,
            'class' => 'form-control ajax-save-answer',
            'data-url' => Url::to('/answer-option/save-answer'),
            'data-question_id' => $answerOptions->question_id ?? $answerId,
            'data-id' => $answerOptions->id,
        ];

        $textInput = Html::textInput("Answer", $answerOptions->answer, $textareaAttributes);
        $label = Html::label('Ответ', null, ['class' => 'form-label']);

        $icon = '<i class="material-icons d-block m-0 p-0">delete</i>';
        $deleteButton = Html::button($icon, ['class' => 'btn btn-danger px-2 confirm-delete ajax-delete-answer', 'title' => 'Удалить ответ']);


        return '<div class="mb-3 ms-5">' . $label . '<div class="input-group">' . $textInput . $deleteButton . '</div></div>';
    }
}
