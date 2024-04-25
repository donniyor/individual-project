<?php

namespace app\helpers;

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Questions;

class QuestionForm
{
    public static function renderQuestionTextarea(Questions $question, int $id): string
    {
        return static::generateTextareaHtml($question, $id);
    }

    protected static function generateTextareaHtml(Questions $question, int $id): string
    {
        $textareaAttributes = [
            'maxlength' => true,
            'class' => 'form-control ajax-question-save',
            'data-url' => Url::to('/question/save-question'),
            'data-quiz_id' => $question->quiz_id ?? $id,
            'data-id' => $question->id
        ];

        $textarea = Html::textarea('QuestionForm', $question->question, $textareaAttributes);
        $label = Html::label('Вопрос', null, ['class' => 'form-label']);
        $icon = '<i class="material-icons d-block m-0 p-0">delete</i>';
        $deleteButton = Html::button($icon, ['class' => 'btn btn-danger px-2 confirm-delete  ajax-delete-question', 'title' => 'Удалить ответ']);

        return "<div class=\"mb-3\">" . $label . "<div class='input-group'>" . $textarea . $deleteButton . "</div></div>";
    }
}
