<?php

use kartik\select2\Select2;

?>

<div class="container mt-3">
    <div class="form-group row">
        <label for="warp_weaver_id" class="col-sm-2 col-form-label col-form-label-lg"><?php echo sprintf('%s :',Yii::t('app', 'Weaver Warp')); ?></label>
        <div class="col-sm-6">
            <?php
                echo Select2::widget(
                    [
                        'name' => 'warp_weaver_id',
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'data' => ['' => Yii::t('app', 'Select Weaver Warp')] + $warpWeaverList,
                        'options' => ['id' => 'warp_weaver_id', 'class' => 'form-control warpWeaverDetailsDropdown']
                    ]
                );
            ?>
        </div>
        <div class="col-sm-3 d-none">
            <button type="button" class="btn btn-primary"><?php echo Yii::t('app', 'Create Next Warp'); ?></button>
        </div>
        <div class="col-sm-3">
            <a href="javascript:;" class="btn btn-small btn-info d-none printWarpWeaverInventory" title="Print" data-model="<?php echo 'MapWarpWeaverInventory'; ?>"><i class="material-icons">print</i></a>
        </div>
    </div>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="spinnerClass" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="row warpWeaverInventoryRecords d-none">
                <div class="col-sm-12 warpWeaverInventoryGrid">
                    <?php 
                        echo $this->render(
                            'warp_weaver_inventory_grid',
                            [
                                'mapWarpWeaverInventoryData' => $mapWarpWeaverInventoryData
                            ]
                        );
                    ?>
                </div>
            </div>
            <h4 class="display-5 warpInitialText"><?php echo Yii::t('app', 'Select Warp to view details.'); ?></h4>
        </div>
    </div>
</div>
