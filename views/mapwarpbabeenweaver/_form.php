<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MapWarpBabeenWeaver */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="map-warp-babeen-weaver-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'babeen_provider_id')->textInput() ?>

    <?= $form->field($model, 'warp_weaver_id')->textInput() ?>

    <?= $form->field($model, 'left_babeen_yelai')->textInput() ?>

    <?= $form->field($model, 'left_babeen_length')->textInput() ?>

    <?= $form->field($model, 'right_babeen_yelai')->textInput() ?>

    <?= $form->field($model, 'right_babeen_length')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'payment_status')->textInput() ?>

    <?= $form->field($model, 'payment_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
