<?php

use app\models\MapWarpWeaver;

$sareeCountCalculation = $mapWarpWeaverInventoryData['manipulated_business_data']['sareeCountCalculation'];
$babeenDetails = $mapWarpWeaverInventoryData['manipulated_business_data']['warpBabeenDetails'];
$warpStatus = MapWarpWeaver::getWarpStatusList();

?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <?php if(empty($isPrint)): ?>
                <input type="number" style="display:none;" class="sareesOutWeaverFees" value="<?php echo $sareeCountCalculation['saree_out_weaver_fees']; ?>">
            <?php endif; ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"><?php echo Yii::t('app', 'Required'); ?></th>
                        <th scope="col"><?php echo Yii::t('app', 'Given'); ?></th>
                        <th scope="col"><?php echo Yii::t('app', 'Needed'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="table-active"><b><?php echo Yii::t('app', 'Sarees'); ?></b></td>
                        <td>
                            <?php 
                                echo sprintf(
                                    '<b>%s</b>', 
                                    $sareeCountCalculation['minimum_sarees'] 
                                ); 
                            ?>
                        </td>
                        <td>
                            <?php 
                                echo sprintf(
                                    '<b>%s %s</b><br><i>Expected Sarees : <b>%s</b></i>',
                                    $sareeCountCalculation['total_sarees_weaver_produced'],
                                    $sareeCountCalculation['total_mistake_sarees_weaver_produced'] > 0 
                                    ? sprintf('( <span style="color:red">%s</span> )', $sareeCountCalculation['total_mistake_sarees_weaver_produced']) 
                                    : '',
                                    $sareeCountCalculation['expected_sarees_produced'], 
                                );
                            ?>
                        </td>
                        <td>
                            <?php 
                                echo sprintf(
                                    '<b>%s</b>', 
                                    $sareeCountCalculation['needed_minimum_sarees'] 
                                ); 
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active" rowspan="3"><b><?php echo Yii::t('app', 'Inventory'); ?></b></td>
                        <td>
                            <?php 
                                echo sprintf(
                                    '%s : <b>%s</b>', 
                                    Yii::t('app', 'Yarn (kgs)'),
                                    $sareeCountCalculation['required_yarn_weight'] 
                                ); 
                            ?>
                        </td>
                        <td>
                            <?php 
                                echo sprintf(
                                    '%s : <b>%s</b>', 
                                    Yii::t('app', 'Yarn (kgs)'),
                                    $sareeCountCalculation['given_yarn_weight'] 
                                ); 
                            ?>
                        </td>
                        <td>
                            <?php 
                                echo sprintf(
                                    '%s : <b>%s</b>', 
                                    Yii::t('app', 'Yarn (kgs)'),
                                    $sareeCountCalculation['needed_yarn_weight'] 
                                ); 
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php 
                                echo sprintf(
                                    '%s : <b>%s</b>', 
                                    Yii::t('app', 'Jarigai (kgs)'),
                                    $sareeCountCalculation['required_jarigai_weight'] 
                                ); 
                            ?>
                        </td>
                        <td>
                            <?php 
                                echo sprintf(
                                    '%s : <b>%s</b>', 
                                    Yii::t('app', 'Jarigai (kgs)'),
                                    $sareeCountCalculation['given_jarigai_weight'] 
                                ); 
                            ?>
                        </td>
                        <td>
                            <?php 
                                echo sprintf(
                                    '%s : <b>%s</b>', 
                                    Yii::t('app', 'Jarigai (kgs)'),
                                    $sareeCountCalculation['needed_jarigai_weight'] 
                                ); 
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php 
                                echo sprintf(
                                    '%s : <b>%s</b>', 
                                    Yii::t('app', 'Babeen (mts)'),
                                    $sareeCountCalculation['required_babeen_meter'] 
                                ); 
                            ?>
                        </td>
                        <td>
                            <?php 
                                echo sprintf(
                                    '%s : <b>%s</b>', 
                                    Yii::t('app', 'Babeen (mts)'),
                                    $sareeCountCalculation['given_babeen_meter'] 
                                ); 
                            ?>
                        </td>
                        <td>
                            <?php 
                                echo sprintf(
                                    '%s : <b>%s</b>', 
                                    Yii::t('app', 'Babeen (mts)'),
                                    $sareeCountCalculation['needed_babeen_meter'] 
                                ); 
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active"><b><?php echo Yii::t('app', 'Babeen Details'); ?></b></td>
                        <td colspan="3">
                            <?php if (!empty($babeenDetails)): ?>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><?php echo Yii::t('app', 'Provider'); ?></th>
                                            <th><?php echo Yii::t('app', 'Left Babeen'); ?></th>
                                            <th><?php echo Yii::t('app', 'Right Babeen'); ?></th>
                                            <th><?php echo Yii::t('app', 'Status'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($babeenDetails as $eachBabeen): ?>
                                            <?php 
                                                echo sprintf(
                                                    '<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
                                                    $eachBabeen['babeen_provider_name'],
                                                    sprintf(
                                                        '<i>%s</i>: <b>%s</b>, <i>%s</i>: <b>%s</b>',
                                                        Yii::t('app', 'Yelai'),
                                                        $eachBabeen['left_babeen_yelai'],
                                                        Yii::t('app', 'Length'), 
                                                        $eachBabeen['left_babeen_length']
                                                    ),
                                                    sprintf(
                                                        '<i>%s</i>: <b>%s</b>, <i>%s</i>: <b>%s</b>',
                                                        Yii::t('app', 'Yelai'),
                                                        $eachBabeen['right_babeen_yelai'],
                                                        Yii::t('app', 'Length'), 
                                                        $eachBabeen['right_babeen_length']
                                                    ),
                                                    $warpStatus[$eachBabeen['status']]
                                                );
                                            ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <?php echo Yii::t('app', 'No Records Found.'); ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-active"><b><?php echo Yii::t('app', 'Additional Details'); ?></b></td>
                        <td colspan="3">
                            <label>
                                <?php 
                                    echo sprintf(
                                        '%s : <b>%s</b>', 
                                        Yii::t('app', 'Given Advance Amount'),
                                        $sareeCountCalculation['total_weaver_advance_fee_inhand'] 
                                    ); 
                                ?>
                            </label>
                            <label class="ml-3">
                                <?php 
                                    echo sprintf(
                                        '%s : <b>%s</b>', 
                                        Yii::t('app', 'Jarigai Kattai Need to return'),
                                        $sareeCountCalculation['needed_jarigai_quantity_to_return']
                                    ); 
                                ?>
                            </label>
                            <?php if (empty($isPrint)): ?>
                                <br>
                                <label>
                                    <?php 
                                        echo sprintf(
                                            '%s : <b>%s</b>', 
                                            Yii::t('app', 'Warp Provider'),
                                            $sareeCountCalculation['warp_provider_name'] 
                                        ); 
                                    ?>
                                </label>
                                <label class="ml-3">
                                    <?php 
                                        echo sprintf(
                                            '%s : <b>%s</b>', 
                                            Yii::t('app', 'Warp Roller'),
                                            $sareeCountCalculation['warp_roller_name']
                                        ); 
                                    ?>
                                </label>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php if (empty($isPrint) && $sareeCountCalculation['warp_status'] !== null): ?>
            <h4 class="warpStatus">
                <span class="badge badge-warning" style="float:right;" data-status="<?php echo $sareeCountCalculation['warp_status']; ?>">
                    <?php echo MapWarpWeaver::getWarpStatusList()[$sareeCountCalculation['warp_status']]; ?>
                </span>
            </h4>
        <?php endif; ?>
    </div>
</div>