<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MapWarpWeaverSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="map-warp-weaver-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'warp_provider_id') ?>

    <?= $form->field($model, 'weaver_id') ?>

    <?= $form->field($model, 'left_pettu_yelai') ?>

    <?php // echo $form->field($model, 'body_yelai') ?>

    <?php // echo $form->field($model, 'right_pettu_yelai') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
