<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MapWarpWeaver;

/**
 * MapWarpWeaverSearch represents the model behind the search form of `app\models\MapWarpWeaver`.
 */
class MapWarpWeaverSearch extends MapWarpWeaver
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'date', 'saree_type_id', 'warp_provider_id', 'weaver_loom_id', 'left_pettu_yelai', 'body_yelai', 'right_pettu_yelai', 'status', 'payment_status', 'minimum_sarees'], 'integer'],
            [['amount'], 'number'],
            [['name', 'warp_roller_name', 'body_colour', 'pettu_colour'], 'string']
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
        $query = MapWarpWeaver::find();

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
            'warp_provider_id' => $this->warp_provider_id,
            'weaver_loom_id' => $this->weaver_loom_id,
            'left_pettu_yelai' => $this->left_pettu_yelai,
            'body_yelai' => $this->body_yelai,
            'right_pettu_yelai' => $this->right_pettu_yelai,
            'amount' => $this->amount,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'minimum_sarees' => $this->minimum_sarees,
            'warp_roller_name' => $this->warp_roller_name,
            'saree_type_id' => $this->saree_type_id,
            'body_colour' => $this->body_colour,
            'pettu_colour' => $this->pettu_colour
        ]);

        if ( is_numeric($this->date)&& (int)$this->date == $this->date ){
            $this->date = date('d-m-Y', $this->date);
        }
        
        return $dataProvider;
    }
}
