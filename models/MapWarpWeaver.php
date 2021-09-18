<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "map_warp_weaver".
 *
 * @property int $id
 * @property int $date
 * @property int $warp_provider_id
 * @property int|null $weaver_loom_id
 * @property int $left_pettu_yelai
 * @property int $body_yelai
 * @property int $right_pettu_yelai
 * @property float $amount
 * @property int $status
 * @property int $payment_status
 * @property int $minimum_sarees
 * @property string $warp_roller_name
 * @property int $saree_type_id
 * @property string $body_colour
 * @property string $pettu_colour
 *
 * @property MapWeaverInventory[] $mapWeaverInventories
 * @property User $warpProvider
 * @property User $weaver
 */
class MapWarpWeaver extends \app\models\BaseModel
{
    const WARP_FINISHED_STATUS = 6;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'map_warp_weaver';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'name', 'warp_provider_id', 'saree_type_id', 'status', 'minimum_sarees'], 'required'],
            [['date', 'saree_type_id', 'warp_provider_id', 'weaver_loom_id', 'left_pettu_yelai', 'body_yelai', 'right_pettu_yelai', 'status', 'payment_status', 'minimum_sarees'], 'integer'],
            [['amount'], 'number'],
            [['name', 'warp_roller_name', 'body_colour', 'pettu_colour'], 'string', 'max' => 250],
            [['warp_provider_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['warp_provider_id' => 'id']],
            [['weaver_loom_id'], 'exist', 'skipOnError' => true, 'targetClass' => MapWeaverLoom::className(), 'targetAttribute' => ['weaver_loom_id' => 'id']],
            [['saree_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => SareeType::className(), 'targetAttribute' => ['saree_type_id' => 'id']],
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
            'warp_provider_id' => Yii::t('app', 'Warp Provider'),
            'weaver_loom_id' => Yii::t('app', 'Weaver Loom'),
            'left_pettu_yelai' => Yii::t('app', 'Left Pettu Yelai'),
            'body_yelai' => Yii::t('app', 'Body Yelai'),
            'right_pettu_yelai' => Yii::t('app', 'Right Pettu Yelai'),
            'amount' => Yii::t('app', 'Amount'),
            'status' => Yii::t('app', 'Status'),
            'payment_status' => Yii::t('app', 'Payment Status'),
            'warp_roller_name' => Yii::t('app', 'Roller Name'),
            'minimum_sarees' => Yii::t('app', 'Minimum Sarees'),
            'saree_type_id' => Yii::t('app', 'Saree Type'),
            'body_color' => Yii::t('app', 'Body Colour'),
            'pettu_color' => Yii::t('app', 'Pettu Colour'),
        ];
    }

    /**
     * Gets query for [[MapWeaverInventories]].
     *
     * @return \yii\db\ActiveQuery|MapWeaverInventoryQuery
     */
    public function getMapWeaverInventories()
    {
        return $this->hasMany(MapWeaverInventory::className(), ['warp_weaver_id' => 'id']);
    }

    /**
     * Gets query for [[WarpProvider]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getWarpProvider()
    {
        return $this->hasOne(User::className(), ['id' => 'warp_provider_id']);
    }

    /**
     * Gets query for [[WeaverLoom]].
     *
     * @return \yii\db\ActiveQuery|MapWeaverLoomQuery
     */
    public function getWeaverLoom()
    {
        return $this->hasOne(MapWeaverLoom::className(), ['id' => 'weaver_loom_id']);
    }

    /**
     * Gets query for [[SareeType]].
     *
     * @return \yii\db\ActiveQuery|SareeType
     */
    public function getSareeType()
    {
        return $this->hasOne(SareeType::className(), ['id' => 'saree_type_id']);
    }

    /**
     * {@inheritdoc}
     * @return MapWarpWeaverQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MapWarpWeaverQuery(get_called_class());
    }

    public function beforeValidate()
    {
        if (!empty($this->date) && ($convertedDate = strtotime($this->date))) {
            $this->date = $convertedDate;
        }
        
        return parent::beforeValidate();
    }

    public static function getWarpWeaverList($warpWeaverId = null, $weaverId = null)
    {
        $sql = 'SELECT
                    ww.id,
                    concat(
                        u.name, 
                        "[ ", wl.loom_name, " ]",
                        "[ ", ww.name, " ]",
                        "[ ", st.name, " ]"
                    ) as "name"
                FROM
                    map_warp_weaver ww
                    JOIN map_weaver_loom as wl ON ww.weaver_loom_id = wl.id
                    JOIN user u on u.id = wl.weaver_id AND u.user_type_id =:user_type_id
                    JOIN saree_type st on st.id = ww.saree_type_id
                WHERE
                    ##CONDITION##
            ';
        $replacement = [1]; $params = [':user_type_id' => UserType::$weaver];
        if ($warpWeaverId !== null) {
            $replacement[] = 'ww.id =:id';
            $params[':id'] = $warpWeaverId;
        }
        if ($weaverId !== null) {
            $replacement[] = 'u.id =:user_id';
            $params[':user_id'] = $weaverId;
        }
        $sql = str_replace('##CONDITION##', implode(' AND ', $replacement), $sql);
        $sqlQuery = Yii::$app->getDb()->createCommand($sql, $params);
        return $sqlQuery->queryAll();
    }
}
