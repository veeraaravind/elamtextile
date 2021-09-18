<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sub_warp_babeen_weaver".
 *
 * @property int $id
 * @property int $warp_weaver_id
 * @property int $warp_babeen_weaver_id
 * @property int $given_babeen_length
 * @property int $utilized_babeen_length
 *
 * @property MapWarpBabeenWeaver $warpBabeenWeaver
 * @property MapWarpWeaver $warpWeaver
 * @property MapWarpWeaver $fromWarpWeaver
 */
class SubWarpBabeenWeaver extends \app\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sub_warp_babeen_weaver';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['warp_babeen_weaver_id', 'given_babeen_length'], 'required'],
            [['warp_weaver_id', 'from_warp_weaver_id', 'warp_babeen_weaver_id'], 'integer'],
            [['given_babeen_length', 'utilized_babeen_length'], 'number'],
            [['from_warp_weaver_id'], 'exist', 'skipOnError' => true, 'targetClass' => MapWarpWeaver::className(), 'targetAttribute' => ['from_warp_weaver_id' => 'id']],
            [['warp_weaver_id'], 'exist', 'skipOnError' => true, 'targetClass' => MapWarpWeaver::className(), 'targetAttribute' => ['warp_weaver_id' => 'id']],
            [['warp_babeen_weaver_id'], 'exist', 'skipOnError' => true, 'targetClass' => MapWarpBabeenWeaver::className(), 'targetAttribute' => ['warp_babeen_weaver_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'from_warp_weaver_id' => Yii::t('app', 'From Warp Weaver'),
            'warp_weaver_id' => Yii::t('app', 'Warp Weaver'),
            'warp_babeen_weaver_id' => Yii::t('app', 'Warp Babeen Weaver'),
            'given_babeen_length' => Yii::t('app', 'Given Babeen Length'),
            'utilized_babeen_length' => Yii::t('app', 'Utilized Babeen Length'),
        ];
    }

    /**
     * Gets query for [[WarpBabeenWeaver]].
     *
     * @return \yii\db\ActiveQuery|MapWarpBabeenWeaverQuery
     */
    public function getWarpBabeenWeaver()
    {
        return $this->hasOne(MapWarpBabeenWeaver::className(), ['id' => 'warp_babeen_weaver_id']);
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
     * Gets query for [[FromWarpWeaver]].
     *
     * @return \yii\db\ActiveQuery|MapWarpWeaverQuery
     */
    public function getFromWarpWeaver()
    {
        return $this->hasOne(MapWarpWeaver::className(), ['id' => 'from_warp_weaver_id']);
    }

    /**
     * {@inheritdoc}
     * @return SubWarpBabeenWeaverQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubWarpBabeenWeaverQuery(get_called_class());
    }
}
