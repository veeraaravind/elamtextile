<?php

namespace app\models;

use Yii;
use app\models\BaseModel;

/**
 * This is the model class for table "user_type".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $code
 * @property int|null $status
 */
class UserType extends BaseModel
{

    public static $weaver = 3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 150],
            [['code'], 'string', 'max' => 50],
            [['name'], 'unique'],
            [['code'], 'unique'],
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
            'code' => Yii::t('app', 'Code'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserTypeQuery(get_called_class());
    }
}
