<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MapWeaverInventory]].
 *
 * @see MapWeaverInventory
 */
class MapWeaverInventoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MapWeaverInventory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MapWeaverInventory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
