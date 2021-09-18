<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $city
 * @property string|null $state
 * @property int|null $pincode
 * @property string|null $phone_number
 * @property int|null $mobile_number
 * @property string $logo
 * @property string|null $gst_number
 */
class Company extends \app\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pincode', 'mobile_number'], 'integer'],
            [['logo'], 'string'],
            [['name', 'address1', 'address2', 'gst_number'], 'string', 'max' => 250],
            [['city', 'state'], 'string', 'max' => 150],
            [['phone_number'], 'string', 'max' => 20],
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
            'address1' => Yii::t('app', 'Address1'),
            'address2' => Yii::t('app', 'Address2'),
            'city' => Yii::t('app', 'City'),
            'state' => Yii::t('app', 'State'),
            'pincode' => Yii::t('app', 'Pincode'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'mobile_number' => Yii::t('app', 'Mobile Number'),
            'gst_number' => Yii::t('app', 'GST Number'),
            'logo' => Yii::t('app', 'Logo'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return CompanyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyQuery(get_called_class());
    }
}
