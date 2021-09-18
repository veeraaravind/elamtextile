<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MapWarpWeaver */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="map-warp-weaver-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'warp_provider_id')->textInput() ?>

    <?= $form->field($model, 'weaver_id')->textInput() ?>

    <?= $form->field($model, 'left_pettu_yelai')->textInput() ?>

    <?= $form->field($model, 'body_yelai')->textInput() ?>

    <?= $form->field($model, 'right_pettu_yelai')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
