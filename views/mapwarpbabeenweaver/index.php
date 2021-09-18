<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MapWarpBabeenWeaverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Map Warp Babeen Weavers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="map-warp-babeen-weaver-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Map Warp Babeen Weaver'), ['create'], ['class' => 'btn btn-success']) ?>
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
            'babeen_provider_id',
            'warp_weaver_id',
            'left_babeen_yelai',
            //'left_babeen_length',
            //'right_babeen_yelai',
            //'right_babeen_length',
            //'amount',
            //'status',
            //'payment_status',
            //'payment_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
