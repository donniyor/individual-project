<?php

namespace app\models;

use app\components\BaseModel;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property string|null $language
 * @property int $telegram_chat_id
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Feedbacks[] $feedbacks
 * @property Transactions[] $transactions
 */
class Users extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'telegram_chat_id'], 'required'],
            [['telegram_chat_id', 'status'], 'default', 'value' => null],
            [['telegram_chat_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 20],
            [['language'], 'string', 'max' => 10],
            [['telegram_chat_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя Пользователя',
            'phone' => 'Телефон',
            'language' => 'Язык',
            'telegram_chat_id' => 'ID Телеграм Чата',
            'status' => 'Статус',
            'created_at' => 'Дата Регистрации',
            'updated_at' => 'Дата Обновления',
        ];
    }

    /**
     * Gets query for [[Feedbacks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbacks()
    {
        return $this->hasMany(Feedbacks::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Transactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transactions::class, ['user_id' => 'id']);
    }

    protected function logTitle(): string
    {
        return 'пользователь';
    }
}
