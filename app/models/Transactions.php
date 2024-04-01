<?php

namespace app\models;

use app\components\BaseModel;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "transactions".
 *
 * @property int $id
 * @property string $uuid
 * @property int|null $kindergarten_id
 * @property string $payment_status
 * @property int $status
 * @property string $prices
 * @property string|null $processing_id
 * @property string|null $gnk_fields
 * @property int $amount
 * @property int $user_id
 * @property string|null $desc
 * @property string|null $tin
 * @property string|null $personal_account
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Kindergartens $kindergarten
 * @property Users $user
 */
class Transactions extends BaseModel
{
    const STATUS_SUCCESS = 'SUCCESS';
    const STATUS_PROCESSING = 'PROCESSING';

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'transactions';
    }

    protected function logTitle(): string
    {
        return 'Транзакцию';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['uuid'], 'string'],
            [['kindergarten_id', 'status', 'amount', 'user_id'], 'default', 'value' => null],
            [['kindergarten_id', 'status', 'amount', 'user_id'], 'integer'],
            [['payment_status', 'prices', 'amount', 'user_id'], 'required'],
            [['prices', 'gnk_fields', 'created_at', 'updated_at'], 'safe'],
            [['payment_status', 'tin'], 'string', 'max' => 20],
            [['processing_id', 'desc'], 'string', 'max' => 255],
            [['personal_account'], 'string', 'max' => 50],
            [['uuid'], 'unique'],
            [['kindergarten_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kindergartens::class, 'targetAttribute' => ['kindergarten_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'uuid' => 'Uuid',
            'kindergarten_id' => 'Детский Сад',
            'payment_status' => 'Статус Оплаты',
            'status' => 'Статус',
            'prices' => 'Назначение',
            'processing_id' => 'ID Процесса',
            'gnk_fields' => 'Gnk Поле',
            'amount' => 'Сумма',
            'user_id' => 'Пользователь',
            'desc' => 'Desc',
            'tin' => 'Tin',
            'personal_account' => 'Персональный Аккаунт',
            'created_at' => 'Дата Добавления',
            'updated_at' => 'Дата Обновления',
        ];
    }

    public function getPaymentStatus(): array
    {
        return [
            self::STATUS_SUCCESS => 'Оплачено',
            self::STATUS_PROCESSING => 'В обработке',
        ];
    }

    public function getPaymentStatusLabel(): string
    {
        return $this->getPaymentStatus()[$this->payment_status] ?? $this->payment_status;
    }

    public function getTotalPrices(self $model, string $space = '<br>'): string
    {
        return is_array($model->prices)
            ? implode($space,
                array_map(fn($price): string => $price['label'] . ' - ' . $price['amount'], (array)$model->prices))
            : $model->prices;
    }

    public static function find(): ActiveQuery
    {
        $query = parent::find();
        if (!Admin::isSuperAdminStatic())
        {
            $query->andWhere(['kindergarten_id' => Admin::getKindergartenId()]);
        }

        return $query->with('user', 'kindergarten')->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * Gets query for [[Kindergarten]].
     *
     * @return ActiveQuery
     */
    public function getKindergarten(): ActiveQuery
    {
        return $this->hasOne(Kindergartens::class, ['id' => 'kindergarten_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }
}
