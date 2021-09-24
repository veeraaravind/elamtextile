<?php

use app\models\MapWarpWeaver;

$isWarpFinished = $mapWarpWeaverInventoryData['manipulated_business_data']['sareeCountCalculation']['warp_status'] == MapWarpWeaver::WARP_FINISHED_STATUS;

?>
<div class="col-sm-12 warpWeaverInventoryBasicDetails">
    <?php 
        echo $this->render(
            'warp_weaver_inventory_overview',
            [
                'mapWarpWeaverInventoryData' => $mapWarpWeaverInventoryData
            ]
        );
    ?>
</div>
<div class="col-sm-12 warpOptionsList mb-1 mt-4">
    <div class="btn-group float-right" role="group" aria-label="Basic example">
        <?php if (!$isWarpFinished): ?>
            <button type="button" class="btn btn-primary mr-1 addWarpWeaverInventory"><?php echo Yii::t('app', 'Add Inventory'); ?></button>
            <button type="button" class="btn btn-primary mr-1 addBabeenToWarp"><?php echo Yii::t('app', 'Add Babeen'); ?></button>
        <?php endif; ?>
        <button type="button" class="btn btn-primary warpWeaverChangeStatus"><?php echo Yii::t('app', 'Change Warp Status'); ?></button>
    </div>
</div>
<table id="MapWarpWeaverInventoryTable" class="table table-striped table-bordered" style="width:100%; background-color:white;">
    <thead>
        <tr>
            <th style="width: 45px;"><?php echo Yii::t('app', 'Date'); ?></th>
            <th><?php echo Yii::t('app', 'Given Jarigai'); ?></th>
            <th><?php echo Yii::t('app', 'Return Jarigai'); ?></th>
            <th><?php echo Yii::t('app', 'Given Yarn'); ?></th>
            <th><?php echo Yii::t('app', 'Return Yarn'); ?></th>
            <th><?php echo Yii::t('app', 'Sarees Count'); ?></th>
            <th><?php echo Yii::t('app', 'Amount'); ?></th>
            <th style="width: 40px;"><?php echo Yii::t('app', ''); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($mapWarpWeaverInventoryData['all_inventory_records']) > 0): ?>
            <?php foreach ($mapWarpWeaverInventoryData['all_inventory_records'] as $eachRecord): ?>
                <tr>
                    <td><?php echo date('d-m-Y', $eachRecord['date']); ?></td>
                    <td><?php echo $eachRecord['given_jarigai_quantity'] ? sprintf('%s( %s )', $eachRecord['given_jarigai_weight'], $eachRecord['given_jarigai_quantity']) : ''; ?></td>
                    <td>
                        <?php 
                            echo $eachRecord['return_jarigai_quantity'] ? 
                                    sprintf(
                                        '%s( %s )', 
                                        $eachRecord['return_jarigai_weight'] != '' ? $eachRecord['return_jarigai_weight'] : '0.000', 
                                        $eachRecord['return_jarigai_quantity']
                                    ) 
                                    : ''; 
                        ?>
                    </td>
                    <td><?php echo $eachRecord['given_yarn_weight'] ? sprintf('%s', $eachRecord['given_yarn_weight']) : ''; ?></td>
                    <td><?php echo $eachRecord['return_yarn_weight'] ? sprintf('%s', $eachRecord['return_yarn_weight']) : ''; ?></td>
                    <td><?php echo $eachRecord['produced_sarees']; ?></td>
                    <td><?php echo floatval($eachRecord['given_amount']) + floatval($eachRecord['given_net_transfer_amount']); ?></td>
                    <td>
                        <a href="javascript:;" class="viewWarpWeaverInventory" title="View" data-id="<?php echo $eachRecord['id']; ?>" data-model="<?php echo 'MapWarpWeaverInventory'; ?>"><i class="material-icons">visibility</i></a> 
                        <?php if (!$isWarpFinished): ?>
                            <a href="javascript:;" class="updateWarpWeaverInventory" title="Update" data-id="<?php echo $eachRecord['id']; ?>" data-model="<?php echo 'MapWarpWeaverInventory'; ?>"><i class="material-icons">edit</i></a> 
                            <a href="javascript:;" class="deleteWarpWeaverInventory" title="Delete" data-id="<?php echo $eachRecord['id']; ?>" data-model="<?php echo 'MapWarpWeaverInventory'; ?>"><i class="material-icons">delete</i></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <?php foreach (range(0, 7) as $value): ?>
                    <td></td>
                <?php endforeach; ?>
            </tr>
        <?php endif; ?>
    </tbody>
</table>