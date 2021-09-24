<?php

use app\models\MapWarpWeaver;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use app\models\UserType;

?>

<div class="container babeenProviderPage">
    <div class="card userDetailUpdate">
        <?php
            echo $this->render(
                'user_details_view', 
                [
                    'model' => $model
                ]
            );
        ?>
    </div>
    <br>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#babeenProviderHome" role="tab" aria-controls="home" aria-selected="true">
                <?php echo Yii::t('app', 'Overview'); ?>
            </a>
        </li>
    </ul>
    <div class="tab-content" id="babeenProviderTab">
        <div class="tab-pane fade show active" id="babeenProviderHome" role="tabpanel" aria-labelledby="home-tab">
            <div class="container">
                <div class="row">
                    <div class="map-warp-weaver-index">

                        <p>
                            <?= Html::a(
                                Yii::t('app', 'Create Babeen'), 
                                'javascript:;', 
                                [
                                    'class' => 'btn btn-success createDataModal createBabeen',
                                    'data-target' => "#mapWarpBabeenWeaverModal",
                                    'data-model' => "MapWarpBabeenWeaver"
                                ]
                            ); ?>
                        </p>

                        <?php Pjax::begin(['id' => 'pjax-grid-view', 'options' => ['data-model' => 'MapWarpBabeenWeaver']]); ?>
                        
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute' => 'date',
                                    'format'=>'raw',
                                    'filter'=>DateRangePicker::widget(
                                        [
                                            'model'=>$searchModel,
                                            'attribute'=>'date',
                                            'convertFormat'=>true,
                                            'pluginOptions'=>[
                                                'singleDatePicker'=>true,
                                                'showDropdowns'=>true,
                                                'locale'=>[
                                                    'format'=>'d-m-Y'
                                                ]
                                            ]
                                        ]
                                    ), 
                                    'value' => function($model){
                                        return $model->getDate();
                                    },
                                    'headerOptions' => ['style' => 'width:15%']
                                ],
                                'name',
                                [
                                    'attribute' => 'warp_weaver_id',
                                    'filter' => Select2::widget(
                                        [
                                            'model' => $searchModel,
                                            'attribute' => 'warp_weaver_id',
                                            'size' => Select2::MEDIUM,
                                            'data' =>  ['' => Yii::t('app', 'Select Weaver Warp')] + $warpWeaverList,
                                            'pluginOptions' => ['width' => '300px']
                                        ]
                                    ),
                                    'format'=>'raw', 
                                    'value' => function($model){
                                        if ($model->warp_weaver_id !== null) {
                                            return MapWarpWeaver::getWarpWeaverList(null, null, $model->warp_weaver_id)[0]['name'];
                                        }
                                        return '';
                                    },
                                ],
                                [
                                    'attribute' => 'status',
                                    'filter' => Select2::widget(
                                        [
                                            'model' => $searchModel,
                                            'attribute' => 'status',
                                            'size' => Select2::MEDIUM,
                                            'data' =>  ['' => Yii::t('app', 'Select Status')] + $searchModel->getWarpStatusList(),
                                            'pluginOptions' => ['width' => '150px']
                                        ]
                                    ),
                                    'format'=>'raw', 
                                    'value' => function($model){
                                        return $model->getWarpStatus();
                                    }
                                ],
                                $searchModel->gridAction(),
                            ],
                        ]); ?>

                        <?php Pjax::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
    echo $this->render(
        'user_creation_modal', 
        [
            'userTypeId' => $model->user_type_id,
            'bankList' => $bankList,
            'can_show_loom_details' => UserType::isWeaver($model->user_type_id)
        ]
    );
?>
<?php
    echo $this->render(
        'warp_babeen_creation_modal', 
        [
            'warpStatusList' => $searchModel->getWarpStatusList(),
            'warpWeaverList' => $warpWeaverList,
            'babeenProviderList' => $babeenProviderList,
            'initialValue' => $initialValue
        ]
    );
?>
<script type="text/javascript">
    var sareeTypeList = <?php echo json_encode($sareeTypeList); ?>;
</script>