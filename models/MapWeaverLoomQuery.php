<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[MapWeaverLoom]].
 *
 * @see MapWeaverLoom
 */
class MapWeaverLoomQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MapWeaverLoom[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MapWeaverLoom|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
