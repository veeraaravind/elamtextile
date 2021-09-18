<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SareeType]].
 *
 * @see SareeType
 */
class SareeTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SareeType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SareeType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
