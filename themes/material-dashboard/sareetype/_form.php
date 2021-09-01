<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SareeType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="saree-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'out_weaver_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'in_weaver_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'yarn_weight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jarigai_weight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'babeen_meter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
