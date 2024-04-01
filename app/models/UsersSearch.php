<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Users;
use yii\db\ActiveQuery;
use \Yii;

/**
 * UsersSearch represents the model behind the search form of `app\models\Users`.
 */
class UsersSearch extends Users
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'telegram_chat_id', 'status'], 'integer'],
            [['name', 'phone', 'language', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
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
     */
    public function search($params)
    {
        $query = Users::find()->orderBy(['created_at' => SORT_DESC]);

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
            'telegram_chat_id' => $this->telegram_chat_id,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
        ]);

        $this->getDate($query);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'language', $this->language]);

        return $dataProvider;
    }

    private function getDate(ActiveQuery $query): ActiveQuery
    {
        if ($this->created_at) {
            $dates = explode(' - ', $this->created_at);
            if (count($dates) == 2) {
                $startDate = Yii::$app->formatter->asDate($dates[0], 'php:Y-m-d');
                $endDate = date('Y-m-d', strtotime(Yii::$app->formatter->asDate($dates[1], 'php:Y-m-d') . ' +1 day'));
                $query->andWhere(['between', 'created_at', $startDate, $endDate]);
            }
        }
        return $query;
    }
}
