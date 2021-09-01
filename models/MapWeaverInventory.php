<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "map_weaver_inventory".
 *
 * @property int $id
 * @property int $warp_weaver_id
 * @property int $inventory_type_id
 * @property int $transaction_type
 * @property float|null $weight
 * @property int|null $quantity
 * @property int|null $yelai
 * @property int|null $length
 * @property int $date
 *
 * @property InventoryType $inventoryType
 * @property MapWarpWeaver $warpWeaver
 */
class MapWeaverInventory extends \app\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'map_weaver_inventory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['warp_weaver_id', 'inventory_type_id', 'transaction_type', 'date'], 'required'],
            [['warp_weaver_id', 'inventory_type_id', 'transaction_type', 'quantity', 'yelai', 'length', 'date'], 'integer'],
            [['weight'], 'number'],
            [['inventory_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => InventoryType::className(), 'targetAttribute' => ['inventory_type_id' => 'id']],
            [['warp_weaver_id'], 'exist', 'skipOnError' => true, 'targetClass' => MapWarpWeaver::className(), 'targetAttribute' => ['warp_weaver_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'warp_weaver_id' => Yii::t('app', 'Warp Weaver ID'),
            'inventory_type_id' => Yii::t('app', 'Inventory Type ID'),
            'transaction_type' => Yii::t('app', 'Transaction Type'),
            'weight' => Yii::t('app', 'Weight'),
            'quantity' => Yii::t('app', 'Quantity'),
            'yelai' => Yii::t('app', 'Yelai'),
            'length' => Yii::t('app', 'Length'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    /**
     * Gets query for [[InventoryType]].
     *
     * @return \yii\db\ActiveQuery|InventoryTypeQuery
     */
    public function getInventoryType()
    {
        return $this->hasOne(InventoryType::className(), ['id' => 'inventory_type_id']);
    }

    /**
     * Gets query for [[WarpWeaver]].
     *
     * @return \yii\db\ActiveQuery|MapWarpWeaverQuery
     */
    public function getWarpWeaver()
    {
        return $this->hasOne(MapWarpWeaver::className(), ['id' => 'warp_weaver_id']);
    }

    /**
     * {@inheritdoc}
     * @return MapWeaverInventoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MapWeaverInventoryQuery(get_called_class());
    }
}
