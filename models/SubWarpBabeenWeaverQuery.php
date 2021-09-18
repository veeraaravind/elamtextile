<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SubWarpBabeenWeaver]].
 *
 * @see SubWarpBabeenWeaver
 */
class SubWarpBabeenWeaverQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SubWarpBabeenWeaver[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SubWarpBabeenWeaver|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
