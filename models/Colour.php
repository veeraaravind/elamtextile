<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "colour".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $code
 * @property int|null $status
 */
class Colour extends \app\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'colour';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['name', 'code'], 'string', 'max' => 50],
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
     * @return ColourQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ColourQuery(get_called_class());
    }
}
