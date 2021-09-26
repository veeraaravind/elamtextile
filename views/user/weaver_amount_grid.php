<?php

use app\models\MapWarpWeaverInventory;

?>
<table id="weaverAmountRecordsTable" class="table table-striped table-bordered" style="width:100%; background-color:white;">
    <thead>
        <tr>
            <th style="width: 45px;"><?php echo Yii::t('app', 'Date'); ?></th>
            <th><?php echo Yii::t('app', 'Weaver'); ?></th>
            <th><?php echo Yii::t('app', 'Total Sarees'); ?></th>
            <th><?php echo Yii::t('app', 'Actual Amount'); ?></th>
            <th><?php echo Yii::t('app', 'Mistake Amount'); ?></th>
            <th><?php echo Yii::t('app', 'Given Amount'); ?></th>
            <th><?php echo Yii::t('app', 'Payment Mode'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($weaverAmountData) > 0): ?>
            <?php foreach ($weaverAmountData as $eachRecord): ?>
                <tr>
                    <td><?php echo date('d-m-Y', $eachRecord['date']); ?></td>
                    <td><?php echo $eachRecord['weaver_name']; ?></td>
                    <td>
                        <?php 
                            echo sprintf(
                                '%s %s', 
                                $eachRecord['produced_sarees'], 
                                $eachRecord['production_return_sarees'] > 0 ? sprintf('( <span style="color:red">%s</span> )', $eachRecord['production_return_sarees']) : ''
                            );
                        ?>
                    </td>
                    <td><?php echo $eachRecord['actual_amount']; ?></td>
                    <td><?php echo $eachRecord['mistake_amount']; ?></td>
                    <td><?php echo number_format($eachRecord['given_amount']+$eachRecord['given_net_transfer_amount'], 2, '.', ''); ?></td>
                    <td><?php echo MapWarpWeaverInventory::getPaymentModeName($eachRecord['payment_mode']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <?php foreach (range(0, 6) as $value): ?>
                    <td></td>
                <?php endforeach; ?>
            </tr>
        <?php endif; ?>
    </tbody>
</table>