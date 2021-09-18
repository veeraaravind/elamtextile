<?php

use app\models\MapWeaverLoom;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use app\models\UserType;
use kartik\color\ColorInput;
use app\models\Colour;

$colourListBreak = array_chunk($colourList, 9);
?>

<div class="container warpProviderPage">
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
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#warpProviderHome" role="tab" aria-controls="home" aria-selected="true">
                <?php echo Yii::t('app', 'Overview'); ?>
            </a>
        </li>
    </ul>
    <div class="tab-content" id="warpProviderTab">
        <div class="tab-pane fade show active" id="warpProviderHome" role="tabpanel" aria-labelledby="home-tab">
            <div class="container">
                <div class="row">
                    <div class="map-warp-weaver-index">

                        <p>
                            <?= Html::a(
                                Yii::t('app', 'Create Warp'), 
                                'javascript:;', 
                                [
                                    'class' => 'btn btn-success createDataModal createWarp',
                                    'data-target' => "#mapWarpWeaverModal",
                                    'data-model' => "MapWarpWeaver"
                                ]
                            ); ?>
                            <?= Html::a(
                                Yii::t('app', 'Payment'), 
                                'javascript:;',
                                [
                                    'class' => 'btn btn-secondary paymentWarp d-none',
                                    'data-target' => "#paymentWarpModal"
                                ]
                            ); ?>
                        </p>

                        <?php Pjax::begin(['id' => 'pjax-grid-view', 'options' => ['data-model' => 'MapWarpWeaver']]); ?>
                        
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                // [
                                //     'class' => 'yii\grid\CheckboxColumn',
                                // ],
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
                                    'attribute' => 'weaver_loom_id',
                                    'filter' => Select2::widget(
                                        [
                                            'model' => $searchModel,
                                            'attribute' => 'weaver_loom_id',
                                            'size' => Select2::MEDIUM,
                                            'data' =>  ['' => Yii::t('app', 'Select Weaver')] + $weaverList,
                                            'pluginOptions' => ['width' => '300px']
                                        ]
                                    ),
                                    'format'=>'raw', 
                                    'value' => function($model){
                                        if ($model->weaver_loom_id !== null) {
                                            return MapWeaverLoom::getWeaverLoomList($model->weaver_loom_id)[0]['name'];
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
                                            'pluginOptions' => ['width' => '200px']
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
<div class="modal fade bd-example-modal-xl" id="mapWarpWeaverModal" role="dialog" aria-labelledby="mapWarpWeaverLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="mapWarpWeaverLabel"><?php echo Yii::t('app', 'Warp')?></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id='mapWarpWeaverForm'>
            <div class="warpCreationDetails">
                <div class="col-md-12 mb-12">
                    <div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <div class="warpOverview">
                                <div class="form-row warpNameDetails">
                                    <div class="col-md-4 mb-4">
                                        <input type="text" name="MapWarpWeaver[warp_provider_id]" class="form-control mandatoryField d-none" id="warp_provider_id" value="<?php echo $model->id; ?>" required>
                                        <label for="date"><?php echo Yii::t('app', 'Date'); ?><span style="color:red">*</span></label>
                                        <?php
                                            echo DateRangePicker::widget([
                                                'name' => 'MapWarpWeaver[date]',
                                                'value' => date('d-m-Y'),
                                                'convertFormat' => true,
                                                'pluginOptions' => [
                                                    'singleDatePicker'=>true,
                                                    'showDropdowns'=>true,
                                                    'locale'=>['format' => 'd-m-Y'],
                                                ],
                                                'options' => [
                                                    'id' => 'date', 'class' => 'form-control mandatoryField', 
                                                    'required' => true, 'autocomplete' => "off"
                                                ]
                                            ]);
                                        ?>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="name"><?php echo Yii::t('app', 'Name'); ?><span style="color:red">*</span></label>
                                        <input type="text" name="MapWarpWeaver[name]" class="form-control" id="name" required>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="status"><?php echo Yii::t('app', 'Status'); ?><span style="color:red">*</span></label>
                                        <?php
                                            echo Select2::widget(
                                                [
                                                    'name' => 'MapWarpWeaver[status]',
                                                    'theme' => Select2::THEME_BOOTSTRAP,
                                                    'data' => ['' => Yii::t('app', 'Select Status')] + $searchModel->getWarpStatusList(),
                                                    'options' => ['id' => 'status', 'class' => 'form-control', 'required' => true]
                                                ]
                                            );
                                        ?>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 mb-4">
                                        <label for="saree_type_id"><?php echo Yii::t('app', 'Saree Type'); ?><span style="color:red">*</span></label>
                                        <?php
                                            echo Select2::widget(
                                                [
                                                    'name' => 'MapWarpWeaver[saree_type_id]',
                                                    'theme' => Select2::THEME_BOOTSTRAP,
                                                    'data' => [
                                                        '' => Yii::t('app', 'Select Saree Type')] + $sareeTypeList,
                                                    'options' => ['id' => 'saree_type_id', 'class' => 'form-control', 'required' => true]
                                                ]
                                            );
                                        ?>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="minimumSarees"><?php echo Yii::t('app', 'Minimum Sarees'); ?><span style="color:red">*</span></label>
                                        <input type="number" name="MapWarpWeaver[minimum_sarees]" class="form-control" id="minimumSarees" min="0" step="1" required>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="warpRollerName"><?php echo Yii::t('app', 'Warp Roller Name'); ?></label>
                                        <input type="text" name="MapWarpWeaver[warp_roller_name]" class="form-control" id="warpRollerName">
                                    </div>
                                </div>
                                <div class="form-row warpWeaverDetails">
                                    <div class="col-md-6 mb-6">
                                        <label for="weaver_loom_id"><?php echo Yii::t('app', 'Weaver'); ?></label>
                                        <?php
                                            echo Select2::widget(
                                                [
                                                    'name' => 'MapWarpWeaver[weaver_loom_id]',
                                                    'theme' => Select2::THEME_BOOTSTRAP,
                                                    'data' => ['' => Yii::t('app', 'Select Weaver')] + $weaverList,
                                                    'options' => ['id' => 'weaver_loom_id', 'class' => 'form-control']
                                                ]
                                            );
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h3><?php echo Yii::t('app', 'Yelai Details'); ?></h3>
                            <div class="warpDetails">
                                <div class="form-row">
                                    <div class="col-md-4 mb-4">
                                        <label for="leftPettuYelai"><?php echo Yii::t('app', 'Left Pettu Yelai'); ?></label>
                                        <input type="number" name="MapWarpWeaver[left_pettu_yelai]" min="0" class="form-control" id="leftPettuYelai">
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="bodyYelai"><?php echo Yii::t('app', 'Udal Yelai'); ?><span style="color:red">*</span></label>
                                        <input type="number" name="MapWarpWeaver[body_yelai]" min="0" class="form-control" id="bodyYelai" required>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="rightPettuYelai"><?php echo Yii::t('app', 'Right Pettu Yelai'); ?></label>
                                        <input type="number" name="MapWarpWeaver[right_pettu_yelai]" min="0" class="form-control" id="rightPettuYelai">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-3 mb-3">
                                        <label for="bodyColour"><?php echo Yii::t('app', 'Udal Colour'); ?><span style="color:red">*</span></label>
                                        <?php echo ColorInput::widget([
                                                'name' => 'MapWarpWeaver[body_colour]',
                                                'showDefaultPalette' => false,
                                                'options' => ['class' => 'form-control', 'id' => 'bodyColour', 'required' => true],
                                                'pluginOptions' => [
                                                    'showPalette' => true,
                                                    'showPaletteOnly' => true,
                                                    'hideAfterPaletteSelect' => true,
                                                    'preferredFormat' => 'name',
                                                    'palette' => $colourListBreak
                                                ],
                                                'pluginEvents' => [
                                                    "change" => "function(colour) { 
                                                        updateColourName('MapWarpWeaver[body_colour]', colour);
                                                        return false;
                                                    }"
                                                ]
                                            ]);
                                        ?>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="pettuColour"><?php echo Yii::t('app', 'Pettu Colour'); ?></label>
                                        <?php echo ColorInput::widget([
                                                'name' => 'MapWarpWeaver[pettu_colour]',
                                                'showDefaultPalette' => false,
                                                'options' => ['class' => 'form-control', 'id' => 'pettuColour'],
                                                'pluginOptions' => [
                                                    'showPalette' => true,
                                                    'showPaletteOnly' => true,
                                                    'hideAfterPaletteSelect' => true,
                                                    'preferredFormat' => 'name',
                                                    'palette' => $colourListBreak
                                                ],
                                                'pluginEvents' => [
                                                    "change" => "function(colour) { 
                                                        updateColourName('MapWarpWeaver[pettu_colour]', colour);
                                                        return false;
                                                    }"
                                                ]
                                            ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="warpProviderFee d-none">
                                <hr>
                                <h3><?php echo Yii::t('app', 'Warp Provider Fee'); ?></h3>
                                <div class="col-md-12 mb-12">
                                    <div class="jumbotron jumbotron-fluid">
                                        <div class="container">
                                            <div class="form-row">
                                                <div class="col-md-4 mb-4">
                                                    <label for="amount"><?php echo Yii::t('app', 'Fee'); ?></label>
                                                    <input type="number" name="MapWarpWeaver[amount]" min="0" placeholder="0.00" step="1.00" pattern="^\d+(?:\.\d{5,2})?$" class="form-control" id="amount">
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
        <button type="button" class="btn btn-primary saveData saveMapWarpWeaver" data-model='MapWarpWeaver'><?php echo Yii::t('app', 'Save'); ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg" id="paymentWarpModal" role="dialog" tabindex="-1" aria-labelledby="paymentWarpLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="paymentWarpLabel"><?php echo Yii::t('app', 'Warp Payment')?></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary paymentWarpConfirmation"><?php echo Yii::t('app', 'Pay'); ?></button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    var sareeTypeList = <?php echo json_encode($sareeTypeList); ?>;
    var colourList = <?php echo json_encode($colourList); ?>;
</script>