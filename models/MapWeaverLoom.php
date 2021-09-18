<?php

namespace app\models;

use Yii;
/**
 * This is the model class for table "map_weaver_loom".
 *
 * @property int $id
 * @property int|null $created_date
 * @property int|null $updated_date
 * @property int|null $updated_by
 * @property int $weaver_id
 * @property string|null $loom_name
 * @property int|null $saree_type_id
 * @property int $status
 *
 * @property SareeType $sareeType
 * @property User $weaver
 */
class MapWeaverLoom extends \app\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'map_weaver_loom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['weaver_id'], 'required'],
            [['created_date', 'updated_date', 'updated_by', 'weaver_id', 'saree_type_id', 'status'], 'integer'],
            [['loom_name'], 'string', 'max' => 50],
            [['saree_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => SareeType::className(), 'targetAttribute' => ['saree_type_id' => 'id']],
            [['weaver_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['weaver_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_date' => Yii::t('app', 'Created Date'),
            'updated_date' => Yii::t('app', 'Updated Date'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'weaver_id' => Yii::t('app', 'Weaver ID'),
            'loom_name' => Yii::t('app', 'Loom Name'),
            'saree_type_id' => Yii::t('app', 'Saree Type ID'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * Gets query for [[SareeType]].
     *
     * @return \yii\db\ActiveQuery|SareeTypeQuery
     */
    public function getSareeType()
    {
        return $this->hasOne(SareeType::className(), ['id' => 'saree_type_id']);
    }

    /**
     * Gets query for [[Weaver]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getWeaver()
    {
        return $this->hasOne(User::className(), ['id' => 'weaver_id']);
    }

    /**
     * {@inheritdoc}
     * @return MapWeaverLoomQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MapWeaverLoomQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_date = time();
            $this->updated_date = time();
            $this->updated_by = Yii::$app->user->identity->id;
        } else {
            $this->updated_date = time();
        }

        return parent::beforeSave($insert);
    }

    public static function getWeaverLoomList($weaverLoomId = null)
    {
        $sql = 'SELECT
                    wl.id,
                    concat(u.name, "[ ", wl.loom_name, " ][ ", st.name, "]") as "name"
                FROM
                    map_weaver_loom as wl
                    JOIN user u on u.id = wl.weaver_id AND u.user_type_id =:user_type_id
                    JOIN saree_type st on st.id = wl.saree_type_id
                WHERE
                    ##CONDITION##
            ';
        $replacement = '1'; $params = [':user_type_id' => UserType::$weaver];
        if ($weaverLoomId !== null) {
            $replacement = 'wl.id =:id';
            $params[':id'] = $weaverLoomId;
        }
        $sql = str_replace('##CONDITION##', $replacement, $sql);
        $sqlQuery = Yii::$app->getDb()->createCommand($sql, $params);
        return $sqlQuery->queryAll();
    }
}
