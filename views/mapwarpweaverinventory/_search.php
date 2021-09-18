<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MapWarpWeaverInventorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="map-warp-weaver-inventory-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'warp_weaver_id') ?>

    <?= $form->field($model, 'from_warp_weaver_id') ?>

    <?= $form->field($model, 'given_yarn_quantity') ?>

    <?php // echo $form->field($model, 'given_yarn_weight') ?>

    <?php // echo $form->field($model, 'return_yarn_quantity') ?>

    <?php // echo $form->field($model, 'return_yarn_weight') ?>

    <?php // echo $form->field($model, 'given_jarigai_quantity') ?>

    <?php // echo $form->field($model, 'given_jarigai_weight') ?>

    <?php // echo $form->field($model, 'return_jarigai_quantity') ?>

    <?php // echo $form->field($model, 'return_jarigai_weight') ?>

    <?php // echo $form->field($model, 'produced_sarees') ?>

    <?php // echo $form->field($model, 'production_return_sarees') ?>

    <?php // echo $form->field($model, 'actual_amount') ?>

    <?php // echo $form->field($model, 'given_amount') ?>

    <?php // echo $form->field($model, 'advance_amount') ?>

    <?php // echo $form->field($model, 'mistake_amount') ?>

    <?php // echo $form->field($model, 'payment_mode') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
