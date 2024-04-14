<?php

namespace app\models;

use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

class TestForm extends Model
{
    public int $quiz_id;
    public int $user_id;

    public int $test_solution_id;

    public array $answer_id;
    public array $question_id;

    public function rules(): array
    {
        return [];
    }

    public function attributeLabels(): array
    {
        return [];
    }

    /**
     * @throws NotFoundHttpException
     */
    public static function getQuiz(int $id): null|array|ActiveRecord
    {
        $model =  Quizizz::find()->where(['id' => $id])->orderBy(['created_at' => SORT_ASC])->with(['questions', 'questions.answerOptions'])->one();
        $model ?? throw new NotFoundHttpException('The requested page does not exist.');
        return $model;
    }

    public function save(): bool
    {
        return true;
    }
}