<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "quizizz".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int|null $user_id
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Questions[] $questions
 * @property TestSolution[] $testSolutions
 * @property Users $user
 */
class Quizizz extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return 'quizizz';
    }

    public function rules(): array
    {
        return [
            [['title', 'description', 'status'], 'required'],
            [['description'], 'string'],
            [['user_id', 'status'], 'default', 'value' => null],
            [['user_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getQuestions(): ActiveQuery
    {
        return $this->hasMany(Questions::class, ['quiz_id' => 'id']);
    }

    public function getTestSolutions(): ActiveQuery
    {
        return $this->hasMany(TestSolution::class, ['quiz_id' => 'id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }
}
