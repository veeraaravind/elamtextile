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
 * @property int $user_id
 * @property float|null $weight
 * @property int|null $quantity
 * @property int|null $yelai
 * @property int|null $length
 * @property int $date
 * @property float $amount
 * @property int $payment_status
 * @property int $status
 *
 * @property InventoryType $inventoryType
 * @property MapWarpWeaver $warpWeaver
 * @property User $user
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
            [['warp_weaver_id', 'date'], 'required'],
            [['warp_weaver_id', 'inventory_type_id', 'user_id', 'transaction_type', 'quantity', 'yelai', 'length', 'date', 'payment_status', 'status'], 'integer'],
            [['weight', 'amount'], 'number'],
            [['inventory_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => InventoryType::className(), 'targetAttribute' => ['inventory_type_id' => 'id']],
            [['warp_weaver_id'], 'exist', 'skipOnError' => true, 'targetClass' => MapWarpWeaver::className(), 'targetAttribute' => ['warp_weaver_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'warp_weaver_id' => Yii::t('app', 'Warp Weaver'),
            'inventory_type_id' => Yii::t('app', 'Inventory Type'),
            'transaction_type' => Yii::t('app', 'Transaction Type'),
            'weight' => Yii::t('app', 'Weight'),
            'quantity' => Yii::t('app', 'Quantity'),
            'yelai' => Yii::t('app', 'Yelai'),
            'length' => Yii::t('app', 'Length'),
            'date' => Yii::t('app', 'Date'),
            'user_id' => Yii::t('app', 'User'),
            'amount' => Yii::t('app', 'Amount'),
            'payment_status' => Yii::t('app', 'Payment Status'),
            'status' => Yii::t('app', 'Status'),
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|User
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return MapWeaverInventoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MapWeaverInventoryQuery(get_called_class());
    }

    public function beforeValidate()
    {
        if (!empty($this->date) && ($convertedDate = strtotime($this->date))) {
            $this->date = $convertedDate;
        }
        
        return parent::beforeValidate();
    }
}
