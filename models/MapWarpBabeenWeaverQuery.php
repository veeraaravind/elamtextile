<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MapWarpBabeenWeaver]].
 *
 * @see MapWarpBabeenWeaver
 */
class MapWarpBabeenWeaverQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MapWarpBabeenWeaver[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MapWarpBabeenWeaver|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
