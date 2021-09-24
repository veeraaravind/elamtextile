<?php

use kartik\select2\Select2;

?>
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
                                <div class="form-row warpStatusFormData">
                                    <div class="col-md-4 mb-4">
                                        <label for="date"><?php echo Yii::t('app', 'Status'); ?><span style="color:red">*</span></label>
                                        <?php
                                            echo Select2::widget(
                                                [
                                                    'name' => 'MapWarpWeaver[status]',
                                                    'theme' => Select2::THEME_BOOTSTRAP,
                                                    'data' => ['' => Yii::t('app', 'Select Status')] + $warpStatusList,
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
                                            <?php 
                                                echo Select2::widget(
                                                    [
                                                        'name' => 'MapWarpWeaverInventory[moving_warp_weaver_id]',
                                                        'theme' => Select2::THEME_BOOTSTRAP,
                                                        'data' => ['' => Yii::t('app', 'Select Warp')],
                                                        'options' => ['id' => 'moving_warp_weaver_id', 'class' => 'form-control', 'required' => true]
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