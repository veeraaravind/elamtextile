<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MapWarpWeaverInventorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Map Warp Weaver Inventories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="map-warp-weaver-inventory-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Map Warp Weaver Inventory'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'date',
            'warp_weaver_id',
            'from_warp_weaver_id',
            'given_yarn_quantity',
            //'given_yarn_weight',
            //'return_yarn_quantity',
            //'return_yarn_weight',
            //'given_jarigai_quantity',
            //'given_jarigai_weight',
            //'return_jarigai_quantity',
            //'return_jarigai_weight',
            //'produced_sarees',
            //'production_return_sarees',
            //'actual_amount',
            //'given_amount',
            //'advance_amount',
            //'mistake_amount',
            //'payment_mode',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
