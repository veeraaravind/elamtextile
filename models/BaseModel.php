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

    public function gridAction()
    {
        return [
            'class'    => 'yii\grid\ActionColumn',
            'template' => '{leadView} {leadUpdate} {leadDelete}',
            'buttons'  => [
                'leadView'   => function ($url, $model) {
                    return Html::a('<i class="material-icons">visibility</i>', 'javascript:;', ['title' => 'View']);
                },
                'leadUpdate' => function ($url, $model) {
                    return Html::a('<i class="material-icons">edit</i>', 'javascript:;', ['title' => 'Update']);
                },
                'leadDelete' => function ($url, $model) {
                    return Html::a('<i class="material-icons">delete</i>', 'javascript:;', ['title' => 'Delete']);
                },
            ]
        ];
    }
}