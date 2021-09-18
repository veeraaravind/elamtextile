<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MapWarpWeaver]].
 *
 * @see MapWarpWeaver
 */
class MapWarpWeaverQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MapWarpWeaver[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MapWarpWeaver|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
