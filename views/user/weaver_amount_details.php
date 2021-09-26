<?php

use kartik\select2\Select2;
use kartik\daterange\DateRangePicker;

?>

<div class="container mt-3 weaverAmountDetails" style="border:1px solid #f5f5f5;">
    <h1><?php echo Yii::t('app', 'Weaver Amount Details'); ?></h1>
    <div class="form-row mt-3">
        <div class="col-sm-3">
            <label for="start_date"><?php echo Yii::t('app', 'Start Date'); ?><span style="color:red">*</span></label>
            <?php
                echo DateRangePicker::widget([
                    'name' => 'start_date',
                    'value' => date('d-m-Y'),
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'singleDatePicker'=>true,
                        'showDropdowns'=>true,
                        'locale'=>['format' => 'd-m-Y'],
                    ],
                    'options' => ['id' => 'start_date', 'class' => 'form-control', 'required' => true]
                ]);
            ?>
        </div>
        <div class="col-sm-3">
            <label for="end_date"><?php echo Yii::t('app', 'End Date'); ?><span style="color:red">*</span></label>
            <?php
                echo DateRangePicker::widget([
                    'name' => 'end_date',
                    'value' => date('d-m-Y'),
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'singleDatePicker'=>true,
                        'showDropdowns'=>true,
                        'locale'=>['format' => 'd-m-Y'],
                    ],
                    'options' => ['id' => 'end_date', 'class' => 'form-control', 'required' => true]
                ]);
            ?>
        </div>
        <div class="col-sm-4">
            <label for="weaver_id"><?php echo Yii::t('app', 'Weaver'); ?><span style="color:red">*</span></label>
            <?php
                echo Select2::widget(
                    [
                        'name' => 'weaver_id',
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'data' => ['' => Yii::t('app', 'Select Weaver')] + $weaverList,
                        'options' => ['id' => 'weaver_id', 'class' => 'form-control weaverDropdown']
                    ]
                );
            ?>
        </div>
        <div class="col-sm-2">
            <button type="button" class="btn btn-small btn-primary searchWeaverAmountDetails mt-4" title="Search"><i class="fa fa-search"></i></button>
        </div>
    </div>
    <div class="jumbotron jumbotron-fluid mt-3">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="spinnerClass" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 weaverAmountRecords d-none">
                </div>
            </div>
            <h4 class="display-5 amountInitialText"><?php echo Yii::t('app', 'Select weaver to view details.'); ?></h4>
        </div>
    </div>
</div>