<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MapWeaverInventory;

/**
 * MapWeaverInventorySearch represents the model behind the search form of `app\models\MapWeaverInventory`.
 */
class MapWeaverInventorySearch extends MapWeaverInventory
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'warp_weaver_id', 'inventory_type_id', 'transaction_type', 'quantity', 'yelai', 'length', 'date', 'status', 'payment_status'], 'integer'],
            [['weight', 'amount'], 'number'],
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
        $query = MapWeaverInventory::find();

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
            'user_id' => $this->user_id,
            'warp_weaver_id' => $this->warp_weaver_id,
            'inventory_type_id' => $this->inventory_type_id,
            'transaction_type' => $this->transaction_type,
            'weight' => $this->weight,
            'quantity' => $this->quantity,
            'yelai' => $this->yelai,
            'length' => $this->length,
            'date' => $this->date,
            'amount' => $this->amount,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
        ]);

        return $dataProvider;
    }
}
