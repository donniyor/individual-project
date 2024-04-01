<?php

namespace app\models;

use app\components\BaseModel;

/**
 * This is the model class for table "regions".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Regions extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'regions';
    }

    protected function logTitle(): string
    {
        return 'регион';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'safe'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'status' => 'Статус',
            'created_at' => 'Дата добавления',
            'updated_at' => 'Дата редактирования',
        ];
    }
}
