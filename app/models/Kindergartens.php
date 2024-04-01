<?php

namespace app\models;

use app\components\BaseModel;
use yii\helpers\Url;

/**
 * This is the model class for table "kindergartens".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $property
 * @property string $tin
 * @property string|null $images
 * @property int $region_id
 * @property string $personal_account
 * @property int $pay_external_service_id
 * @property int $pay_client_id
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Admin[] $admins
 * @property Feedbacks[] $feedbacks
 * @property Regions $region
 * @property Transactions[] $transactions
 */
class Kindergartens extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kindergartens';
    }

    protected function logTitle(): string
    {
        return 'Детский сад';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'property', 'tin', 'region_id', 'personal_account', 'pay_external_service_id', 'pay_client_id'], 'required'],
            [['name', 'images', 'address', 'created_at', 'updated_at'], 'safe'],
            [['images'], 'file', 'skipOnError' => false, 'extensions' => 'jpg, jpeg, svg, png'],
            [['images'], 'required', 'on' => 'create'],
            [['property'], 'string'],
            [['name', 'address'], 'validateJson'],
            [['region_id', 'pay_external_service_id', 'pay_client_id', 'status'], 'default', 'value' => null],
            [['region_id', 'pay_external_service_id', 'pay_client_id', 'status'], 'integer'],
            [['tin'], 'string', 'max' => 50],
            [['personal_account'], 'string', 'max' => 255],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Regions::class, 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'address' => 'Адрес',
            'property' => 'Тип',
            'tin' => 'ИНН',
            'images' => 'Картинка',
            'region_id' => 'Регион',
            'personal_account' => 'Лицевой Счет',
            'pay_external_service_id' => 'Pay External Service ID',
            'pay_client_id' => 'Pay Client ID',
            'status' => 'Статус',
            'created_at' => 'Дата Добавления',
            'updated_at' => 'Дата Обновления',
        ];
    }

    /**
     * Gets query for [[Admins]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdmins()
    {
        return $this->hasMany(Admin::class, ['kindergarten_id' => 'id']);
    }

    /**
     * Gets query for [[Feedbacks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbacks()
    {
        return $this->hasMany(Feedbacks::class, ['kindergarten_id' => 'id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Regions::class, ['id' => 'region_id']);
    }

    /**
     * Gets query for [[Transactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transactions::class, ['kindergarten_id' => 'id']);
    }

    public static function getPropertyList(): array
    {
        return ['public' => 'Государственные', 'private' => 'Частные'];
    }
}
