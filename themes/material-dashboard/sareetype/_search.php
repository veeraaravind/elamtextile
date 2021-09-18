<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SareeTypeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="saree-type-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'out_weaver_fee') ?>

    <?= $form->field($model, 'in_weaver_fee') ?>

    <?= $form->field($model, 'yarn_weight') ?>

    <?php // echo $form->field($model, 'jarigai_weight') ?>

    <?php // echo $form->field($model, 'babeen_meter') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
