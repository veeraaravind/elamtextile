<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MapWarpBabeenWeaver;

/**
 * MapWarpBabeenWeaverSearch represents the model behind the search form of `app\models\MapWarpBabeenWeaver`.
 */
class MapWarpBabeenWeaverSearch extends MapWarpBabeenWeaver
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'date', 'babeen_provider_id', 'warp_weaver_id', 'left_babeen_yelai', 'left_babeen_length', 'right_babeen_yelai', 'right_babeen_length', 'status', 'payment_status', 'payment_date'], 'integer'],
            [['amount'], 'number'],
            [['name'], 'string'],
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
        $query = MapWarpBabeenWeaver::find();

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
            'name' => $this->name,
            'date' => $this->date,
            'babeen_provider_id' => $this->babeen_provider_id,
            'warp_weaver_id' => $this->warp_weaver_id,
            'left_babeen_yelai' => $this->left_babeen_yelai,
            'left_babeen_length' => $this->left_babeen_length,
            'right_babeen_yelai' => $this->right_babeen_yelai,
            'right_babeen_length' => $this->right_babeen_length,
            'amount' => $this->amount,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'payment_date' => $this->payment_date,
        ]);

        if ( is_numeric($this->date)&& (int)$this->date == $this->date ){
            $this->date = date('d-m-Y', $this->date);
        }
        
        return $dataProvider;
    }
}
