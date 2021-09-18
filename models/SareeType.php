<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "saree_type".
 *
 * @property int $id
 * @property string|null $name
 * @property float $out_weaver_fee
 * @property float $in_weaver_fee
 * @property float $yarn_weight
 * @property float $jarigai_weight
 * @property float $babeen_meter
 * @property int|null $status
 * @property int|null $pettu_type
 *
 * @property MapWeaverLoom[] $mapWeaverLooms
 */
class SareeType extends \app\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'saree_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['out_weaver_fee', 'in_weaver_fee', 'yarn_weight', 'jarigai_weight', 'babeen_meter'], 'number'],
            [['status', 'pettu_type'], 'integer'],
            [['name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'out_weaver_fee' => Yii::t('app', 'Out Weaver Fee'),
            'in_weaver_fee' => Yii::t('app', 'In Weaver Fee'),
            'yarn_weight' => Yii::t('app', 'Yarn Weight (kgs)'),
            'jarigai_weight' => Yii::t('app', 'Jarigai Weight (kgs)'),
            'babeen_meter' => Yii::t('app', 'Babeen Length (mts)'),
            'status' => Yii::t('app', 'Status'),
            'pettu_type' => Yii::t('app', 'Pettu Type'),
        ];
    }

    /**
     * Gets query for [[MapWeaverLooms]].
     *
     * @return \yii\db\ActiveQuery|MapWeaverLoomQuery
     */
    public function getMapWeaverLooms()
    {
        return $this->hasMany(MapWeaverLoom::className(), ['saree_type_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return SareeTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SareeTypeQuery(get_called_class());
    }

    public function getPettuType()
    {
        return [
            '1' => Yii::t('app', 'One Side Pettu'),
            '2' => Yii::t('app', 'Double Side Pettu'),
            '3' => Yii::t('app', 'No Pettu')
        ];
    }
}
