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
                                            return MapWarpWeaver::getWarpWeaverList($model->warp_weaver_id)[0]['name'];
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
<div class="modal fade bd-example-modal-xl" id="mapWarpBabeenWeaverModal" role="dialog" aria-labelledby="mapWarpBabeenWeaverLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="mapWarpBabeenWeaverLabel"><?php echo Yii::t('app', 'Babeen')?></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id='mapWarpBabeenWeaverForm'>
            <div class="babeenWeaverCreateDetails">
                <div class="col-md-12 mb-12">
                    <div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <div class="babeenWeaverOverview">
                                <div class="form-row babeenWeaverDetails">
                                    <div class="col-md-4 mb-4">
                                        <input type="text" name="MapWarpBabeenWeaver[babeen_provider_id]" class="form-control mandatoryField d-none" id="babeen_provider_id" value="<?php echo $model->id; ?>" required>
                                        <label for="date"><?php echo Yii::t('app', 'Date'); ?><span style="color:red">*</span></label>
                                        <?php
                                            echo DateRangePicker::widget([
                                                'name' => 'MapWarpBabeenWeaver[date]',
                                                'value' => date('d-m-Y'),
                                                'convertFormat' => true,
                                                'pluginOptions' => [
                                                    'singleDatePicker'=>true,
                                                    'showDropdowns'=>true,
                                                    'locale'=>['format' => 'd-m-Y'],
                                                ],
                                                'options' => ['id' => 'date', 'class' => 'form-control mandatoryField', 'required' => true]
                                            ]);
                                        ?>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="name"><?php echo Yii::t('app', 'Name'); ?><span style="color:red">*</span></label>
                                        <input type="text" name="MapWarpBabeenWeaver[name]" class="form-control" id="name" required>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="status"><?php echo Yii::t('app', 'Status'); ?><span style="color:red">*</span></label>
                                        <?php
                                            echo Select2::widget(
                                                [
                                                    'name' => 'MapWarpBabeenWeaver[status]',
                                                    'theme' => Select2::THEME_BOOTSTRAP,
                                                    'data' => ['' => Yii::t('app', 'Select Status')] + $searchModel->getWarpStatusList(),
                                                    'options' => ['id' => 'status', 'class' => 'form-control', 'required' => true]
                                                ]
                                            );
                                        ?>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 mb-6">
                                        <label for="weaver_loom_id"><?php echo Yii::t('app', 'Weaver Warp'); ?></label>
                                        <?php
                                            echo Select2::widget(
                                                [
                                                    'name' => 'MapWarpBabeenWeaver[warp_weaver_id]',
                                                    'theme' => Select2::THEME_BOOTSTRAP,
                                                    'data' => ['' => Yii::t('app', 'Select Weaver Warp')] + $warpWeaverList,
                                                    'options' => ['id' => 'warp_weaver_id', 'class' => 'form-control']
                                                ]
                                            );
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h3><?php echo Yii::t('app', 'Yelai Details'); ?></h3>
                            <div class="yelaiDetails">
                                <div class="form-row leftBabeenDetails">
                                    <div class="col-md-4 mb-4">
                                        <label for="leftBabeenYelai"><?php echo Yii::t('app', 'Left Babeen Yelai'); ?></label>
                                        <input type="number" name="MapWarpBabeenWeaver[left_babeen_yelai]" min="0" class="form-control" id="leftBabeenYelai">
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="leftBabeenLength"><?php echo Yii::t('app', 'Left Babeen Length'); ?></label>
                                        <input type="number" name="MapWarpBabeenWeaver[left_babeen_length]" min="0" class="form-control" id="leftBabeenLength">
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <input type="checkbox" class="mt-5" id="sameForRightBabeen">
                                        <label for="sameForRightBabeen"><?php echo Yii::t('app', 'Click to copy for Right Babeen'); ?></label>
                                    </div>
                                </div>
                                <div class="form-row rightBabeenDetails">
                                    <div class="col-md-4 mb-4">
                                        <label for="rightBabeenYelai"><?php echo Yii::t('app', 'Right Babeen Yelai'); ?></label>
                                        <input type="number" name="MapWarpBabeenWeaver[right_babeen_yelai]" min="0" class="form-control" id="rightBabeenYelai">
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="rightBabeenLength"><?php echo Yii::t('app', 'Right Babeen Length'); ?></label>
                                        <input type="number" name="MapWarpBabeenWeaver[right_babeen_length]" min="0" class="form-control" id="rightBabeenLength">
                                    </div>
                                </div>
                            </div>
                            <div class="babeenProviderFee d-none">
                                <hr>
                                <h3><?php echo Yii::t('app', 'Babeen Provider Fee'); ?></h3>
                                <div class="col-md-12 mb-12">
                                    <div class="jumbotron jumbotron-fluid">
                                        <div class="container">
                                            <div class="form-row">
                                                <div class="col-md-4 mb-4">
                                                    <label for="amount"><?php echo Yii::t('app', 'Fee'); ?></label>
                                                    <input type="number" name="MapWarpBabeenWeaver[amount]" min="0" placeholder="0.00" step="1.00" pattern="^\d+(?:\.\d{5,2})?$" class="form-control" id="amount">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary saveData saveMapWarpBabeenWeaver" data-model='MapWarpBabeenWeaver'><?php echo Yii::t('app', 'Save'); ?></button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    var sareeTypeList = <?php echo json_encode($sareeTypeList); ?>;
</script>