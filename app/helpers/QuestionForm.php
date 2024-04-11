<?php

namespace app\helpers;

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Questions;

class QuestionForm
{
    public static function renderQuestionTextarea(Questions $question): string
    {
        return static::generateTextareaHtml($question);
    }

    protected static function generateTextareaHtml(Questions $question): string
    {
        $textareaAttributes = [
            'maxlength' => true,
            'class' => 'form-control ajax-question-save',
            'data-url' => Url::to('/question/save-question'),
            'data-quiz_id' => $question->quiz_id,
            'data-id' => $question->id,
            'data-question_id' => $question->id ?? ''
        ];

        $textarea = Html::textarea('QuestionForm', $question->question, $textareaAttributes);
        $label = Html::label('Вопрос', null, ['class' => 'form-label']);

        return "<div class=\"mb-3\">$label$textarea</div>";
    }
}
