<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kindergartens;

/**
 * KindergartensSearch represents the model behind the search form of `app\models\Kindergartens`.
 */
class KindergartensSearch extends Kindergartens
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'region_id', 'pay_external_service_id', 'pay_client_id', 'status'], 'integer'],
            [['name', 'property', 'tin', 'images', 'personal_account', 'created_at', 'updated_at'], 'safe'],
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
        $query = Kindergartens::find()->with('region')->orderBy(['created_at' => SORT_DESC]);

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
            'region_id' => $this->region_id,
            'pay_external_service_id' => $this->pay_external_service_id,
            'pay_client_id' => $this->pay_client_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'property', $this->property])
            ->andFilterWhere(['ilike', 'tin', $this->tin])
            ->andFilterWhere(['ilike', 'images', $this->images])
            ->andFilterWhere(['ilike', 'personal_account', $this->personal_account]);

        return $dataProvider;
    }
}
