<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inventory_type".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $code
 * @property int $status
 *
 * @property MapWeaverInventory[] $mapWeaverInventories
 */
class InventoryType extends \app\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inventory_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['code'], 'string', 'max' => 15],
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
            'code' => Yii::t('app', 'Code'),
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
        return $this->hasMany(MapWeaverInventory::className(), ['inventory_type_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return InventoryTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InventoryTypeQuery(get_called_class());
    }
}
