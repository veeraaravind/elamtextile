<div class="card-header">
    <h3 class="card-title"><?php echo $model->name?></h3>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-md-4 mb-4">
            <h5><?php echo Yii::t('app', 'Mobile Number'); ?></h5>
            <p class="mobile_number"><?php echo !empty($model->mobile_number) ? $model->mobile_number : '--'; ?></p>
        </div>
        <div class="col-md-4 mb-4">
            <h5><?php echo Yii::t('app', 'Address'); ?></h5>
            <p class="address"><?php echo !empty($model->address) ? $model->address : '--'; ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-4">
            <h5><?php echo Yii::t('app', 'Bank'); ?></h5>
            <p class="bank_id"><?php echo $model->bank ? $model->bank->name : '--'; ?></p>
        </div>
        <div class="col-md-4 mb-4">
            <h5><?php echo Yii::t('app', 'Bank Account Number'); ?></h5>
            <p class="bank_account_number"><?php echo !empty($model->bank_account_number) ? $model->bank_account_number : '--'; ?></p>
        </div>
        <div class="col-md-4 mb-4">
            <h5><?php echo Yii::t('app', 'Bank IFSC Code'); ?></h5>
            <p class="bank_ifsc_code"><?php echo !empty($model->bank_ifsc_code) ? $model->bank_ifsc_code : '--'; ?></p>
        </div>
    </div>
    <a href="#" class="btn btn-primary userDetailsEdit" data-id="<?php echo $model->id; ?>" data-model="<?php echo basename(get_class($model)); ?>">
        <?php echo Yii::t('app', 'Edit'); ?>
    </a>
</div>
    