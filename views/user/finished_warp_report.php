<?php

use kartik\select2\Select2;

?>

<div class="container mt-3 finishedWarpDetails" style="border:1px solid #f5f5f5;">
    <h1><?php echo Yii::t('app', 'Finished Warp Details'); ?></h1>
    <div class="form-row mt-3">
        <div class="col-sm-4">
            <label for="weaver_loom_id"><?php echo Yii::t('app', 'Weaver Loom'); ?><span style="color:red">*</span></label>
            <?php
                echo Select2::widget(
                    [
                        'name' => 'weaver_loom_id',
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'data' => ['' => Yii::t('app', 'Select Weaver Loom')] + $weaverLoomList,
                        'options' => ['id' => 'weaver_loom_id', 'class' => 'form-control weaverLoomDropdown']
                    ]
                );
            ?>
        </div>
        <div class="col-sm-6">
            <label for="warp_weaver_id"><?php echo Yii::t('app', 'Warp Weaver'); ?><span style="color:red">*</span></label>
            <?php
                echo Select2::widget(
                    [
                        'name' => 'warp_weaver_id',
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'data' => ['' => Yii::t('app', 'Select Weaver Warp')],
                        'options' => ['id' => 'warp_weaver_id', 'class' => 'form-control warpWeaverDropdown']
                    ]
                );
            ?>
        </div>
        <div class="col-sm-2">
            <button type="button" class="btn btn-small btn-primary searchWarpDetails mt-4" title="Search"><i class="fa fa-search"></i></button>
            <button type="button" class="btn btn-small btn-info d-none printWarpWeaverInventory mt-4" title="Print"><i class="fa fa-print"></i></button>
        </div>
    </div>
    <div class="jumbotron jumbotron-fluid mt-3">
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
<?php
    echo $this->render(
        'update_warp_status_modal', 
        [
            'warpStatusList' => $warpStatusList
        ]
    );
?>