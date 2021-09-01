<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[InventoryType]].
 *
 * @see InventoryType
 */
class InventoryTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return InventoryType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return InventoryType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
