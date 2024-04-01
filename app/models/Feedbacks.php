<?php

namespace app\models;

use app\components\BaseModel;
use app\helpers\Image;
use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "feedbacks".
 *
 * @property int $id
 * @property int $user_id
 * @property int $kindergarten_id
 * @property string|null $images
 * @property string $phone
 * @property string $subject
 * @property string $message
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Kindergartens $kindergarten
 * @property Users $user
 */
class Feedbacks extends BaseModel
{
    protected function logTitle(): string
    {
        return "Отзыв";
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedbacks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'kindergarten_id', 'phone', 'subject', 'message'], 'required'],
            [['user_id', 'kindergarten_id'], 'default', 'value' => null],
            [['user_id', 'kindergarten_id'], 'integer'],
            [['images', 'created_at', 'updated_at'], 'safe'],
            [['message'], 'string'],
            [['phone'], 'string', 'max' => 20],
            [['subject'], 'string', 'max' => 255],
            [['kindergarten_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kindergartens::class, 'targetAttribute' => ['kindergarten_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'kindergarten_id' => 'Детский Сад',
            'images' => 'Фото',
            'phone' => 'Номер Телефона',
            'subject' => 'Предмет',
            'message' => 'Сообщение',
            'created_at' => 'Дата Добавления',
            'updated_at' => 'Дата Обновления',
        ];
    }

    public function getAllImages(self $model, string $space = ''): string|null
    {
        return is_array($model->images) ?
            implode($space, array_map(fn($image): string => Image::make($image), (array)$model->images))
            : $model->images;
    }

    /**
     * Gets query for [[Kindergarten]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKindergarten()
    {
        return $this->hasOne(Kindergartens::class, ['id' => 'kindergarten_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }
}
