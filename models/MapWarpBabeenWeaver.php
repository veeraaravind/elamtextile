<?php

namespace app\models;

use Yii;
use app\models\SubWarpBabeenWeaver;

/**
 * This is the model class for table "map_warp_babeen_weaver".
 *
 * @property int $id
 * @property string $name
 * @property int $date
 * @property int $babeen_provider_id
 * @property int|null $warp_weaver_id
 * @property int|null $left_babeen_yelai
 * @property int|null $left_babeen_length
 * @property int|null $right_babeen_yelai
 * @property int|null $right_babeen_length
 * @property float|null $amount
 * @property int|null $status
 * @property int|null $payment_status
 * @property int|null $payment_date
 *
 * @property User $babeenProvider
 * @property MapWarpWeaver $warpWeaver
 */
class MapWarpBabeenWeaver extends \app\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'map_warp_babeen_weaver';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'name', 'babeen_provider_id'], 'required'],
            [['date', 'babeen_provider_id', 'warp_weaver_id', 'left_babeen_yelai', 'left_babeen_length', 'right_babeen_yelai', 'right_babeen_length', 'status', 'payment_status', 'payment_date'], 'integer'],
            [['amount'], 'number'],
            [['name'], 'string'],
            [['babeen_provider_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['babeen_provider_id' => 'id']],
            [['warp_weaver_id'], 'exist', 'skipOnError' => true, 'targetClass' => MapWarpWeaver::className(), 'targetAttribute' => ['warp_weaver_id' => 'id']],
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
            'date' => Yii::t('app', 'Date'),
            'babeen_provider_id' => Yii::t('app', 'Babeen Provider'),
            'warp_weaver_id' => Yii::t('app', 'Warp Weaver'),
            'left_babeen_yelai' => Yii::t('app', 'Left Babeen Yelai'),
            'left_babeen_length' => Yii::t('app', 'Left Babeen Length'),
            'right_babeen_yelai' => Yii::t('app', 'Right Babeen Yelai'),
            'right_babeen_length' => Yii::t('app', 'Right Babeen Length'),
            'amount' => Yii::t('app', 'Amount'),
            'status' => Yii::t('app', 'Status'),
            'payment_status' => Yii::t('app', 'Payment Status'),
            'payment_date' => Yii::t('app', 'Payment Date'),
        ];
    }

    /**
     * Gets query for [[BabeenProvider]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getBabeenProvider()
    {
        return $this->hasOne(User::className(), ['id' => 'babeen_provider_id']);
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
     * {@inheritdoc}
     * @return MapWarpBabeenWeaverQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MapWarpBabeenWeaverQuery(get_called_class());
    }

    public function beforeValidate()
    {
        if (!empty($this->date) && ($convertedDate = strtotime($this->date))) {
            $this->date = $convertedDate;
        }
        
        return parent::beforeValidate();
    }

    public function afterSave($insert, $changedAttributes)
    {
        $totalMeters = intval($this->right_babeen_length)+intval($this->left_babeen_length);
        $model = SubWarpBabeenWeaver::find()->where(['warp_babeen_weaver_id' => $this->id])->one();
        if (!$model) {
            $model = new SubWarpBabeenWeaver;
        }
        $data = [
            'SubWarpBabeenWeaver' => [
                'given_babeen_length' => $totalMeters, 
                'warp_babeen_weaver_id' => $this->id,
                'warp_weaver_id' => $this->warp_weaver_id
            ]
        ];
        if (!$model->load($data) || !$model->save()) {
            throw new \Exception(Yii::t('app', 'Error in saving data'));
        }

        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeDelete()
    {
        $model = SubWarpBabeenWeaver::find()->where(['warp_babeen_weaver_id' => $this->id])->one();
        if ($model && !$model->delete()) {
            throw new \Exception(Yii::t('app', 'Error in deleting data'));
        }
        return parent::beforeDelete();
    }

    public function getwarpBabeenDetails($warpWeaverId)
    {
        $sql = 'SELECT
                    wbw.*,
                    swbw.given_babeen_length AS consolidated_given_babeen_length,
                    swbw.utilized_babeen_length,
                    swbw.id as sub_warp_babeen_weaver_id,
                    u.name AS babeen_provider_name
                FROM
                    sub_warp_babeen_weaver swbw
                    JOIN map_warp_babeen_weaver wbw ON swbw.warp_babeen_weaver_id = wbw.id
                    JOIN user u ON u.id = wbw.babeen_provider_id
                WHERE
                    swbw.warp_weaver_id =:warpWeaverId';
        $sqlQuery = Yii::$app->getDb()->createCommand($sql, [':warpWeaverId' => $warpWeaverId]);
        
        return $sqlQuery->queryAll();
    }
}
