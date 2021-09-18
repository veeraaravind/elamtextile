<?php

use app\models\MapWeaverLoom;
use yii\helpers\Html;

?>
<div class="container warpPaymentRecords">
    <table class="table table-bordered">
        <thead>
            <tr class="table-active">
                <th scope="col"><?php echo Yii::t('app', 'S.No'); ?></th>
                <th scope="col"><?php echo Yii::t('app', 'Warp Details'); ?></th>
                <th scope="col"><?php echo Yii::t('app', 'Amount'); ?></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($warpRecords): ?>
                <?php foreach ($warpRecords as $index => $eachRecord): ?>
                    <tr>
                        <td><?php echo $index+1; ?></td>
                        <td>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $eachRecord->name; ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        <?php echo MapWeaverLoom::getWeaverLoomList($eachRecord->weaver_loom_id)[0]['name']; ?>
                                    </h6>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        <?php 
                                            echo sprintf(
                                                '%s - %s -%s',
                                                $eachRecord->left_pettu_yelai,
                                                $eachRecord->body_yelai,
                                                $eachRecord->right_pettu_yelai
                                            ); 
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="number" name="MapWarpWeaver[<?php echo $eachRecord->id; ?>][amount]" min="0" placeholder="0.00" step="1.00" pattern="^\d+(?:\.\d{5,2})?$" class="form-control">
                        </td>
                        <td>
                            <?php echo Html::a('<i class="material-icons">delete</i>', 'javascript:;', ['title' => 'Delete', 'class' => 'deleteWarpPaymentRecord']); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr class="totalCalulcation">
                    <td colspan="2"><h4 class="float-right"><?php echo Yii::t('app', 'Total Amount'); ?></h4></td>
                    <td><h4 class="warpPaymentTotalAmount">0.00</h4></td>
                    <td></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="4"><?php echo Yii::t('app', 'No Record Found'); ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>