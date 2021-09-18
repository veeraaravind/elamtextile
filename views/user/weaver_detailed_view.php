<?php

use yii\helpers\Html;
use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use app\models\MapWarpWeaverInventory;

?>

<div class="container weaverDetailedPage">
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
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#weaverDetailedHome" role="tab" aria-controls="home" aria-selected="true">
                <?php echo Yii::t('app', 'Overview'); ?>
            </a>
        </li>
    </ul>
    <div class="tab-content" id="weaverDetailedTab">
        <?php 
            echo $this->render(
                'warp_weaver_inventory_main_page',
                [
                    'warpWeaverList' => $warpWeaverList,
                    'mapWarpWeaverInventoryData' => $mapWarpWeaverInventoryData
                ]
            );
        ?>
    </div>
</div>
<?php 
    echo $this->render(
        'user_creation_modal', 
        [
            'userTypeId' => $model->user_type_id,
            'bankList' => $bankList,
            'can_show_loom_details' => true
        ]
    );
?>
<div class="modal fade bd-example-modal-xl" id="mapWarpWeaverInventoryModal" role="dialog" tabindex="-1" aria-labelledby="mapWarpWeaverInventoryLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="mapWarpWeaverInventoryLabel"><?php echo Yii::t('app', 'Inventory')?></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id='mapWarpWeaverInventoryForm'>
            <div class="col-md-12 mb-12">
                <div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <div class="form-row">
                            <div class="col-md-4 mb-4">
                                <input type="text" name="MapWarpWeaverInventory[warp_weaver_id]" class="form-control d-none" id="warp_weaver_id" value="" required>
                                <label for="date"><?php echo Yii::t('app', 'Date'); ?><span style="color:red">*</span></label>
                                <?php
                                    echo DateRangePicker::widget([
                                        'name' => 'MapWarpWeaverInventory[date]',
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
                        </div>
                        <hr>
                        <h3><?php echo Yii::t('app', 'Yarn Details'); ?></h3>
                        <div class="form-row warpWeaverYarnDetails">
                            <div class="col-md-4 mb-4 pr-4 border-right">
                                <label for="givenYarnWeight"><?php echo Yii::t('app', 'Given Yarn Weight'); ?></label>
                                <input type="number" name="MapWarpWeaverInventory[given_yarn_weight]" min="0" placeholder="0.000" step="1.000" pattern="^\d+(?:\.\d{5,3})?$" class="form-control" id="givenYarnWeight">
                            </div>
                            <div class="col-md-4 mb-4 pl-4">
                                <label for="returnYarnWeight"><?php echo Yii::t('app', 'Return Yarn Weight'); ?></label>
                                <input type="number" name="MapWarpWeaverInventory[return_yarn_weight]" min="0" placeholder="0.000" step="1.000" pattern="^\d+(?:\.\d{5,3})?$" class="form-control" id="returnYarnWeight">
                            </div>
                        </div>
                        <hr>
                        <h3><?php echo Yii::t('app', 'Jarigai Details'); ?></h3>
                        <div class="form-row warpWeaverJarigaiDetails">
                            <div class="col-md-3 mb-3">
                                <label for="givenJarigaiQuantity"><?php echo Yii::t('app', 'Given Jarigai Quantity'); ?></label>
                                <input type="number" name="MapWarpWeaverInventory[given_jarigai_quantity]" min="0" step="1" class="form-control" id="givenJarigaiQuantity">
                            </div>
                            <div class="col-md-3 mb-3 pr-4 border-right">
                                <label for="givenJarigaiWeight"><?php echo Yii::t('app', 'Given Jarigai Weight'); ?></label>
                                <input type="number" name="MapWarpWeaverInventory[given_jarigai_weight]" min="0" placeholder="0.000" step="1.000" pattern="^\d+(?:\.\d{5,3})?$" class="form-control" id="givenJarigaiWeight">
                            </div>
                            <div class="col-md-3 mb-3 pl-4">
                                <label for="returnJarigaiQuantity"><?php echo Yii::t('app', 'Return Jarigai Quantity'); ?></label>
                                <input type="number" name="MapWarpWeaverInventory[return_jarigai_quantity]" min="0" step="1" class="form-control" id="returnJarigaiQuantity">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="returnJarigaiWeight"><?php echo Yii::t('app', 'Return Jarigai Weight'); ?></label>
                                <input type="number" name="MapWarpWeaverInventory[return_jarigai_weight]" min="0" placeholder="0.000" step="1.000" pattern="^\d+(?:\.\d{5,3})?$" class="form-control" id="returnJarigaiWeight">
                            </div>
                        </div>
                        <hr>
                        <h3><?php echo Yii::t('app', 'Sarees Details'); ?></h3>
                        <div class="form-row warpWeaverSareesDetails">
                            <div class="col-md-4 mb-4">
                                <label for="producedSarees"><?php echo Yii::t('app', 'Total Sarees'); ?></label>
                                <input type="number" name="MapWarpWeaverInventory[produced_sarees]" min="0" class="form-control" id="producedSarees">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="productionReturnSarees"><?php echo Yii::t('app', 'Mistake Sarees in total sarees'); ?></label>
                                <input type="number" name="MapWarpWeaverInventory[production_return_sarees]" min="0" class="form-control" id="productionReturnSarees">
                            </div>
                        </div>
                        <hr>
                        <h3><?php echo Yii::t('app', 'Weaver Fee'); ?></h3>
                        <div class="form-row warpWeaverFee">
                            <div class="col-md-3 mb-3">
                                <label for="actualAmount"><?php echo Yii::t('app', 'Actual Amount'); ?></label>
                                <input type="number" name="MapWarpWeaverInventory[actual_amount]" min="0" placeholder="0.00" step="1.00" pattern="^\d+(?:\.\d{5,2})?$" class="form-control actual_amount" id="actualAmount" disabled>
                                <input class="form-control d-none actual_amount" type="number" name="MapWarpWeaverInventory[actual_amount]" min="0" placeholder="0.00" step="1.00" pattern="^\d+(?:\.\d{5,2})?$">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="givenAmount"><?php echo Yii::t('app', 'Given Cash Amount'); ?></label>
                                <input type="number" name="MapWarpWeaverInventory[given_amount]" min="0" placeholder="0.00" step="1.00" pattern="^\d+(?:\.\d{5,2})?$" class="form-control" id="givenAmount">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="givenNetTransferAmount"><?php echo Yii::t('app', 'Given Net Transfer Amount'); ?></label>
                                <input type="number" name="MapWarpWeaverInventory[given_net_transfer_amount]" min="0" placeholder="0.00" step="1.00" pattern="^\d+(?:\.\d{5,2})?$" class="form-control" id="givenNetTransferAmount">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="mistakeAmount"><?php echo Yii::t('app', 'Mistake Deduction Amount'); ?></label>
                                <input type="number" name="MapWarpWeaverInventory[mistake_amount]" min="0" placeholder="0.00" step="1.00" pattern="^\d+(?:\.\d{5,2})?$" class="form-control" id="mistakeAmount">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary saveData saveMapWarpWeaverInventory" data-model='MapWarpWeaverInventory'><?php echo Yii::t('app', 'Save'); ?></button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade bd-example-modal-xl" id="warpWeaverChangeStatusModal" role="dialog" aria-labelledby="warpWeaverChangeStatusLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="warpWeaverChangeStatusLabel"><?php echo Yii::t('app', 'Change Warp Status'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id='warpWeaverChangeStatusForm'>
                    <div class="col-md-12 mb-12">
                        <div class="jumbotron jumbotron-fluid">
                            <div class="container">
                                <div class="form-row">
                                    <div class="col-md-4 mb-4">
                                        <label for="date"><?php echo Yii::t('app', 'Status'); ?><span style="color:red">*</span></label>
                                        <?php
                                            echo Select2::widget(
                                                [
                                                    'name' => 'MapWarpWeaver[status]',
                                                    'theme' => Select2::THEME_BOOTSTRAP,
                                                    'data' => ['' => Yii::t('app', 'Select Status')] + $model->getWarpStatusList(),
                                                    'options' => ['id' => 'status', 'class' => 'form-control', 'required' => true]
                                                ]
                                            );
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="movingWarpStatusDetails d-none">
                        <hr>
                        <h3><?php echo Yii::t('app', 'Remaining Inventory Details'); ?></h3>
                        <div class="col-md-12 mb-12">
                            <div class="jumbotron jumbotron-fluid">
                                <div class="container">
                                    <div class="form-row">
                                        <div class="col-md-4 mb-4">
                                            <label for="movingWarpWeaver"><?php echo Yii::t('app', 'Warp'); ?><span style="color:red">*</span></label>
                                            <?= Html::dropDownList(
                                                    'MapWarpWeaverInventory[moving_warp_weaver_id]', 
                                                    null, 
                                                    ['' => Yii::t('app', 'Select Warp')],
                                                    [
                                                        'class' => 'form-control',
                                                        'required' => true,
                                                        'id' => 'moving_warp_weaver_id'
                                                    ]
                                                ); 
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-3 mb-3">
                                            <label for="MovingYarnWeight"><?php echo Yii::t('app', 'Moving Yarn Weight'); ?></label>
                                            <input type="number" name="MapWarpWeaverInventory[moving_given_yarn_weight]" min="0" placeholder="0.000" step="1.000" pattern="^\d+(?:\.\d{5,3})?$" class="form-control" id="MovingYarnWeight">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="movingJarigaiQuantity"><?php echo Yii::t('app', 'Moving Jarigai quantity'); ?></label>
                                            <input type="number" name="MapWarpWeaverInventory[moving_given_jarigai_quantity]" min="0" step="1" class="form-control" id="movingJarigaiQuantity">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="movingJarigaiWeight"><?php echo Yii::t('app', 'Moving Jarigai Weight'); ?></label>
                                            <input type="number" name="MapWarpWeaverInventory[moving_given_jarigai_weight]" min="0" placeholder="0.000" step="1.000" pattern="^\d+(?:\.\d{5,3})?$" class="form-control" id="movingJarigaiWeight">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="movingBabeenMeter"><?php echo Yii::t('app', 'Moving Babeen Meter'); ?></label>
                                            <input type="number" name="MapWarpWeaverInventory[moving_given_babeen_meter]" min="0" placeholder="0.000" step="1.000" class="form-control" id="movingBabeenMeter">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-3 mb-3">
                                            <label for="movingAdvanceAmount"><?php echo Yii::t('app', 'Moving Advance Amount'); ?></label>
                                            <input type="number" name="MapWarpWeaverInventory[moving_given_amount]" min="0" placeholder="0.000" step="1.000" pattern="^\d+(?:\.\d{5,2})?$" class="form-control" id="movingAdvanceAmount">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary saveMovingMapWarpWeaverInventory" data-model='MapWarpWeaverInventory'><?php echo Yii::t('app', 'Save'); ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var sareeTypeList = <?php echo json_encode($sareeTypeList); ?>;
</script>