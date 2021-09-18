<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MapWarpWeaverInventory;

/**
 * MapWarpWeaverInventorySearch represents the model behind the search form of `app\models\MapWarpWeaverInventory`.
 */
class MapWarpWeaverInventorySearch extends MapWarpWeaverInventory
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'date', 'warp_weaver_id', 'from_warp_weaver_id', 'given_yarn_quantity', 'return_yarn_quantity', 'given_jarigai_quantity', 'return_jarigai_quantity', 'produced_sarees', 'production_return_sarees', 'payment_mode'], 'integer'],
            [['given_yarn_weight', 'return_yarn_weight', 'given_jarigai_weight', 'return_jarigai_weight', 'actual_amount', 'given_amount', 'given_net_transfer_amount', 'advance_amount', 'mistake_amount'], 'number'],
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
        $query = MapWarpWeaverInventory::find();

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
            'date' => $this->date,
            'warp_weaver_id' => $this->warp_weaver_id,
            'from_warp_weaver_id' => $this->from_warp_weaver_id,
            'given_yarn_quantity' => $this->given_yarn_quantity,
            'given_yarn_weight' => $this->given_yarn_weight,
            'return_yarn_quantity' => $this->return_yarn_quantity,
            'return_yarn_weight' => $this->return_yarn_weight,
            'given_jarigai_quantity' => $this->given_jarigai_quantity,
            'given_jarigai_weight' => $this->given_jarigai_weight,
            'return_jarigai_quantity' => $this->return_jarigai_quantity,
            'return_jarigai_weight' => $this->return_jarigai_weight,
            'produced_sarees' => $this->produced_sarees,
            'production_return_sarees' => $this->production_return_sarees,
            'actual_amount' => $this->actual_amount,
            'given_amount' => $this->given_amount,
            'advance_amount' => $this->advance_amount,
            'mistake_amount' => $this->mistake_amount,
            'payment_mode' => $this->payment_mode,
            'given_net_transfer_amount' => $this->given_net_transfer_amount
        ]);

        if (is_numeric($this->date) && (int)$this->date == $this->date) {
            $this->date = date('d-m-Y', $this->date);
        }

        return $dataProvider;
    }
}
