<table id="weaverInventoryRecordsTable" class="table table-striped table-bordered" style="width:100%; background-color:white;">
    <thead>
        <tr>
            <th style="width: 45px;"><?php echo Yii::t('app', 'Date'); ?></th>
            <th><?php echo Yii::t('app', 'Weaver'); ?></th>
            <th><?php echo Yii::t('app', 'Given Yarn (kgs)'); ?></th>
            <th><?php echo Yii::t('app', 'Given Jarigai (kgs)'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($weaverInventoryData) > 0): ?>
            <?php foreach ($weaverInventoryData as $eachRecord): ?>
                <tr>
                    <td><?php echo date('d-m-Y', $eachRecord['date']); ?></td>
                    <td><?php echo $eachRecord['weaver_name']; ?></td>
                    <td><?php echo $eachRecord['given_yarn_weight']; ?></td>
                    <td>
                        <?php 
                            echo sprintf(
                                '%s ( %s )', 
                                $eachRecord['given_jarigai_weight'], 
                                $eachRecord['given_jarigai_quantity'] > 0 ? $eachRecord['given_jarigai_quantity'] : '0'
                            );
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <?php foreach (range(0, 3) as $value): ?>
                    <td></td>
                <?php endforeach; ?>
            </tr>
        <?php endif; ?>
    </tbody>
</table>