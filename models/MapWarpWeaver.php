<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "map_warp_weaver".
 *
 * @property int $id
 * @property int $date
 * @property int $warp_provider_id
 * @property int|null $weaver_id
 * @property int $left_pettu_yelai
 * @property int $body_yelai
 * @property int $right_pettu_yelai
 * @property float $amount
 * @property int $status
 *
 * @property MapWeaverInventory[] $mapWeaverInventories
 * @property User $warpProvider
 * @property User $weaver
 */
class MapWarpWeaver extends \app\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'map_warp_weaver';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'warp_provider_id', 'status'], 'required'],
            [['date', 'warp_provider_id', 'weaver_id', 'left_pettu_yelai', 'body_yelai', 'right_pettu_yelai', 'status'], 'integer'],
            [['amount'], 'number'],
            [['warp_provider_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['warp_provider_id' => 'id']],
            [['weaver_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['weaver_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'date' => Yii::t('app', 'Date'),
            'warp_provider_id' => Yii::t('app', 'Warp Provider ID'),
            'weaver_id' => Yii::t('app', 'Weaver ID'),
            'left_pettu_yelai' => Yii::t('app', 'Left Pettu Yelai'),
            'body_yelai' => Yii::t('app', 'Body Yelai'),
            'right_pettu_yelai' => Yii::t('app', 'Right Pettu Yelai'),
            'amount' => Yii::t('app', 'Amount'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * Gets query for [[MapWeaverInventories]].
     *
     * @return \yii\db\ActiveQuery|MapWeaverInventoryQuery
     */
    public function getMapWeaverInventories()
    {
        return $this->hasMany(MapWeaverInventory::className(), ['warp_weaver_id' => 'id']);
    }

    /**
     * Gets query for [[WarpProvider]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getWarpProvider()
    {
        return $this->hasOne(User::className(), ['id' => 'warp_provider_id']);
    }

    /**
     * Gets query for [[Weaver]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getWeaver()
    {
        return $this->hasOne(User::className(), ['id' => 'weaver_id']);
    }

    /**
     * {@inheritdoc}
     * @return MapWarpWeaverQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MapWarpWeaverQuery(get_called_class());
    }
}
