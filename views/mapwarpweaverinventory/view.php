<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MapWarpWeaverInventory */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Map Warp Weaver Inventories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="map-warp-weaver-inventory-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'date',
            'warp_weaver_id',
            'from_warp_weaver_id',
            'given_yarn_quantity',
            'given_yarn_weight',
            'return_yarn_quantity',
            'return_yarn_weight',
            'given_jarigai_quantity',
            'given_jarigai_weight',
            'return_jarigai_quantity',
            'return_jarigai_weight',
            'produced_sarees',
            'production_return_sarees',
            'actual_amount',
            'given_amount',
            'advance_amount',
            'mistake_amount',
            'payment_mode',
        ],
    ]) ?>

</div>
