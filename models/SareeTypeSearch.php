<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SareeType;

/**
 * SareeTypeSearch represents the model behind the search form of `app\models\SareeType`.
 */
class SareeTypeSearch extends SareeType
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['name'], 'safe'],
            [['out_weaver_fee', 'in_weaver_fee', 'yarn_weight', 'jarigai_weight', 'babeen_meter'], 'number'],
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
        $query = SareeType::find();

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
            'out_weaver_fee' => $this->out_weaver_fee,
            'in_weaver_fee' => $this->in_weaver_fee,
            'yarn_weight' => $this->yarn_weight,
            'jarigai_weight' => $this->jarigai_weight,
            'babeen_meter' => $this->babeen_meter,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
