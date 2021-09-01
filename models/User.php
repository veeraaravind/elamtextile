<?php

namespace app\models;

use Yii;
use app\models\BaseModel;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $password
 * @property string|null $mobile_number
 * @property string|null $address
 * @property string|null $bank_account_number
 * @property string|null $bank_ifsc_code
 * @property string|null $auth_key
 * @property string|null $access_token
 * @property int|null $status
 * @property int|null $created_date
 * @property int|null $updated_date
 * @property int|null $updated_by
 * @property int|null $user_type_id
 * @property int|null $bank_id
 *
 * @property UserType $userType
 * @property Bank $bank
 */
class User extends BaseModel implements \yii\web\IdentityInterface
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'created_date', 'updated_date', 'updated_by', 'user_type_id', 'bank_id'], 'integer'],
            [['name', 'mobile_number', 'password', 'access_token', 'auth_key', 'address'], 'string', 'max' => 150],
            [['bank_account_number', 'bank_ifsc_code'], 'string', 'max' => 50],
            [['mobile_number'], 'unique'],
            [['bank_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bank::className(), 'targetAttribute' => ['bank_id' => 'id']],
            [['user_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserType::className(), 'targetAttribute' => ['user_type_id' => 'id']],
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
            'name' => Yii::t('app', 'Name'),
            'mobile_number' => Yii::t('app', 'Mobile Number'),
            'password' => Yii::t('app', 'Password'),
            'address' => Yii::t('app', 'Address'),
            'bank_id' => Yii::t('app', 'Bank'),
            'user_type_id' => Yii::t('app', 'User Type'),
            'status' => Yii::t('app', 'Status'),
            'bank_account_number' => Yii::t('app', 'Bank Account Number'),
            'bank_ifsc_code' => Yii::t('app', 'Bank IFSC Code')
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return $this->access_token;
    }

    /**
     * Finds user by mobile_number
     *
     * @param string $mobile_number
     * @return static|null
     */
    public static function findByMobileNumber($mobileNumber)
    {
        return self::findOne(['mobile_number'=>$mobileNumber]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    /**
     * Gets query for [[UserType]].
     *
     * @return \yii\db\ActiveQuery|UserTypeQuery
     */
    public function getUserType()
    {
        return $this->hasOne(UserType::className(), ['id' => 'user_type_id']);
    }

    /**
     * Gets query for [[Bank]].
     *
     * @return \yii\db\ActiveQuery|BankQuery
     */
    public function getBank()
    {
        return $this->hasOne(Bank::className(), ['id' => 'bank_id']);
    }

}
