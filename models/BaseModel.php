<?php

namespace app\models;

use Yii;
use yii\helpers\Html; 

class BaseModel extends \yii\db\ActiveRecord
{

    /**
     * This methos is common for all models
     */
    public function getStatus(): string 
    {
        return self::getStatusList()[$this->status];
    }

    public static function getStatusList(): array 
    {   
        return [
            1 => Yii::t('app', 'Active'),
            0 => Yii::t('app', 'Inactive')
        ];
    }

    public function getPaymentStatus(): string 
    {
        return self::getPaymentStatusList()[$this->payment_status];
    }

    public static function getPaymentStatusList(): array 
    {   
        return [
            1 => Yii::t('app', 'Unpaid'),
            0 => Yii::t('app', 'Paid')
        ];
    }

    public static function getWarpStatusList()
    {
        return [
            1 => Yii::t('app', 'Initiated'),
            2 => Yii::t('app', 'Delivered to company'),
            3 => Yii::t('app', 'Weaver taken'),
            4 => Yii::t('app', 'Weaver Using'),
            5 => Yii::t('app', 'Mistake'),
            6 => Yii::t('app', 'Finished')
        ];
    }

    public static function getPaymentModeName($paymentMode)
    {
        if ($paymentMode !== null && is_numeric($paymentMode)) {
            $paymentModes = self::getPaymentMode();
            return isset($paymentModes[$paymentMode]) ? $paymentModes[$paymentMode] : '';
        }
        return '';
    }

    public static function getPaymentMode()
    {
        return [
            1 => Yii::t('app', 'Cash'),
            2 => Yii::t('app', 'Net Transfer'),
            3 => Yii::t('app', 'Cash & Net Transfer')
        ];
    }

    public function getWarpStatus()
    {
        return self::getWarpStatusList()[$this->status]; 
    }

    public function getDate()
    {
        return date('d-m-Y', $this->date);
    }

    public function gridAction()
    {
        return [
            'class'    => 'yii\grid\ActionColumn',
            'template' => '{View} {Update} {Delete}',
            'buttons'  => [
                'View'   => function ($url, $model) {
                    return Html::a('<i class="material-icons">visibility</i>', 'javascript:;', ['title' => 'View']);
                },
                'Update' => function ($url, $model) {
                    return Html::a('<i class="material-icons">edit</i>', 'javascript:;', ['title' => 'Update']);
                },
                'Delete' => function ($url, $model) {
                    return Html::a('<i class="material-icons">delete</i>', 'javascript:;', ['title' => 'Delete']);
                },
            ]
        ];
    }
}