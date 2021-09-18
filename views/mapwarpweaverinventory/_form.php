<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MapWarpWeaverInventory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="map-warp-weaver-inventory-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'warp_weaver_id')->textInput() ?>

    <?= $form->field($model, 'from_warp_weaver_id')->textInput() ?>

    <?= $form->field($model, 'given_yarn_quantity')->textInput() ?>

    <?= $form->field($model, 'given_yarn_weight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'return_yarn_quantity')->textInput() ?>

    <?= $form->field($model, 'return_yarn_weight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'given_jarigai_quantity')->textInput() ?>

    <?= $form->field($model, 'given_jarigai_weight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'return_jarigai_quantity')->textInput() ?>

    <?= $form->field($model, 'return_jarigai_weight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'produced_sarees')->textInput() ?>

    <?= $form->field($model, 'production_return_sarees')->textInput() ?>

    <?= $form->field($model, 'actual_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'given_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'advance_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mistake_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_mode')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
