<?php

namespace app\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * TransactionsSearch represents the model behind the search form of `app\models\Transactions`.
 */
class TransactionsSearch extends Transactions
{
    public string $start = '';
    public string $end = '';

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'kindergarten_id', 'status', 'amount', 'user_id'], 'integer'],
            [['uuid', 'payment_status', 'prices', 'processing_id', 'gnk_fields', 'desc', 'tin', 'personal_account', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     * @throws InvalidConfigException
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Transactions::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'kindergarten_id' => $this->kindergarten_id,
            'status' => $this->status,
            'amount' => $this->amount,
            'user_id' => $this->user_id,
            'updated_at' => $this->updated_at,
        ]);

        $this->getDate($query);

        $query->andFilterWhere(['ilike', 'uuid', $this->uuid])
            ->andFilterWhere(['ilike', 'payment_status', $this->payment_status])
            ->andFilterWhere(['ilike', 'prices', $this->prices])
            ->andFilterWhere(['ilike', 'processing_id', $this->processing_id])
            ->andFilterWhere(['ilike', 'gnk_fields', $this->gnk_fields])
            ->andFilterWhere(['ilike', 'desc', $this->desc])
            ->andFilterWhere(['ilike', 'tin', $this->tin])
            ->andFilterWhere(['ilike', 'personal_account', $this->personal_account]);


        return $dataProvider;
    }

    /**
     * @throws InvalidConfigException
     */
    public function getDate(ActiveQuery $query): void
    {
        if ($this->created_at) {
            $dates = explode(' - ', $this->created_at);
            if (count($dates) == 2) {
                $startDate = Yii::$app->formatter->asDate($dates[0], 'php:Y-m-d');
                $endDate = date('Y-m-d', strtotime(Yii::$app->formatter->asDate($dates[1], 'php:Y-m-d') . ' +1 day'));
                $query->andWhere(['between', 'created_at', $startDate, $endDate]);
                $this->start = $startDate;
                $this->end = $endDate;
            }
        }
    }


    /**
     * @throws InvalidConfigException
     */
    public function getTransactionAmount(): array
    {
        $query = self::find()->select([
            'TO_CHAR(created_at, \'YYYY-MM-DD\') AS created_at',
            'SUM(amount) AS amount'
        ]);

        $this->getDate($query);

        return $query->groupBy(new Expression('TO_CHAR(created_at, \'YYYY-MM-DD\')'))
            ->orderBy(['created_at' => SORT_ASC])
            ->andWhere(['payment_status' => self::STATUS_SUCCESS])
            ->asArray()
            ->all();
    }
}
