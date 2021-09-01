<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'created_date') ?>

    <?= $form->field($model, 'updated_date') ?>

    <?= $form->field($model, 'updated_by') ?>

    <?= $form->field($model, 'user_type_id') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'mobile_number') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'bank_id') ?>

    <?php // echo $form->field($model, 'bank_account_number') ?>

    <?php // echo $form->field($model, 'bank_ifsc_code') ?>

    <?php // echo $form->field($model, 'auth_key') ?>

    <?php // echo $form->field($model, 'access_token') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
