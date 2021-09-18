<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h4 style="color: #F81D2D;"><strong><?php echo $company['name']?></strong></h4>
                    <p>
                        <?php echo $company['address1']?><br>
                        <?php echo $company['address2']?><br>
                        <?php echo sprintf('%s - %s', $company['city'], $company['pincode']); ?>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>
                                    <?php 
                                        $sareeCountCalculation = $mapWarpWeaverInventoryData['manipulated_business_data']['sareeCountCalculation']; 
                                        echo sprintf(
                                            '%s<br>%s<br>%s<br>%s<br>%s',
                                            sprintf('<b>Weaver Name :</b> %s [ %s ]', $sareeCountCalculation['weaver_name'], $sareeCountCalculation['loom_name']),
                                            sprintf('<b>Saree Type :</b> %s', $sareeCountCalculation['saree_type_name']),
                                            sprintf('<b>Warp :</b> %s', $sareeCountCalculation['warp_name']),
                                            sprintf('<b>Warp Provider:</b> %s', $sareeCountCalculation['warp_provider_name']),
                                            sprintf('<b>Warp Roller:</b> %s', $sareeCountCalculation['warp_roller_name'])
                                        );
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <?php 
                        echo $this->render(
                            '/user/warp_weaver_inventory_overview',
                            [
                                'mapWarpWeaverInventoryData' => $mapWarpWeaverInventoryData,
                                'isPrint' => true
                            ]
                        );
                    ?>
                </div>
            </div>
            <hr>
            <h4><?php echo sprintf('%s :', Yii::t('app', 'Inventory Details')); ?></h4>
            <div class="row">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th><?php echo Yii::t('app', 'Date'); ?></th>
                            <th><?php echo Yii::t('app', 'Given Jarigai'); ?></th>
                            <th><?php echo Yii::t('app', 'Return Jarigai'); ?></th>
                            <th><?php echo Yii::t('app', 'Given Yarn'); ?></th>
                            <th><?php echo Yii::t('app', 'Return Yarn'); ?></th>
                            <th><?php echo Yii::t('app', 'Total Sarees'); ?></th>
                            <th><?php echo Yii::t('app', 'Mistake Deduction Amount'); ?></th>
                            <th><?php echo Yii::t('app', 'Given Amount'); ?></th>
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
                                    <td>
                                        <?php 
                                            $mistakeSarees = $eachRecord['production_return_sarees'] > 0 ? sprintf('(<span style="color:red">%s</span>)', $eachRecord['production_return_sarees']) : '';
                                            echo sprintf('%s%s', $eachRecord['produced_sarees'], $mistakeSarees); 
                                        ?>
                                    </td>
                                    <td><?php echo floatval($eachRecord['mistake_amount']); ?></td>
                                    <td><?php echo floatval($eachRecord['given_amount']) + floatval($eachRecord['given_net_transfer_amount']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8"><?php echo Yii::t('app', 'No records Found'); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
