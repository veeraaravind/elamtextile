<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MapWarpWeaverInventory]].
 *
 * @see MapWarpWeaverInventory
 */
class MapWarpWeaverInventoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MapWarpWeaverInventory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MapWarpWeaverInventory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
