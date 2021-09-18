<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MapWarpBabeenWeaverSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="map-warp-babeen-weaver-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'babeen_provider_id') ?>

    <?= $form->field($model, 'warp_weaver_id') ?>

    <?= $form->field($model, 'left_babeen_yelai') ?>

    <?php // echo $form->field($model, 'left_babeen_length') ?>

    <?php // echo $form->field($model, 'right_babeen_yelai') ?>

    <?php // echo $form->field($model, 'right_babeen_length') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'payment_status') ?>

    <?php // echo $form->field($model, 'payment_date') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
