<?php

namespace app\models;

use app\components\BaseModel;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "test_solution".
 *
 * @property int $id
 * @property int $user_id
 * @property int $quiz_id
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property ProblemSolving[] $problemSolvings
 * @property Quizizz $quiz
 * @property Users $user
 */
class TestSolution extends BaseModel
{
    public static function tableName(): string
    {
        return 'test_solution';
    }

    public function rules(): array
    {
        return [
            [['user_id', 'quiz_id', 'status'], 'required'],
            [['user_id', 'quiz_id', 'status'], 'default', 'value' => null],
            [['user_id', 'quiz_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quizizz::class, 'targetAttribute' => ['quiz_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'quiz_id' => 'Quiz ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getProblemSolvings(): ActiveQuery
    {
        return $this->hasMany(ProblemSolving::class, ['test_solution_id' => 'id']);
    }

    public function getQuiz(): ActiveQuery
    {
        return $this->hasOne(Quizizz::class, ['id' => 'quiz_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    protected function logTitle(): string
    {
        return 'решение теста';
    }
}
