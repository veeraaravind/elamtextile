<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Company');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!--p>
        <?= Html::a(
                Yii::t('app', 'Create Company'), 
                ['create'], 
                [
                    'class' => 'btn btn-success createDataModal createCompany',
                    'data-target' => "#companyModal",
                    'data-model' => "Company"
                ]
            ) 
        ?>
    </p-->

    <?php Pjax::begin(['id' => 'pjax-grid-view', 'options' => ['data-model' => 'Company']]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'address1',
            'address2',
            'city',
            'state',
            'pincode',
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{View} {Update}',
                'buttons'  => [
                    'View'   => function ($url, $model) {
                        return Html::a('<i class="material-icons">visibility</i>', 'javascript:;', ['title' => 'View']);
                    },
                    'Update' => function ($url, $model) {
                        return Html::a('<i class="material-icons">edit</i>', 'javascript:;', ['title' => 'Update']);
                    }
                ]
            ]
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
<div class="modal fade bd-example-modal-xl" id="companyModal" role="dialog" aria-labelledby="companyLabel" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="companyLabel"><?php echo Yii::t('app', 'Company'); ?></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id='companyForm'>
            <div class="companyDetails">
                <div class="col-md-12 mb-12">
                    <div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <div class="form-row">
                                <div class="col-md-4 mb-4">
                                    <label for="name"><?php echo Yii::t('app', 'Name'); ?><span style="color:red">*</span></label>
                                    <input type="text" name="Company[name]" class="form-control" id="name" required>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="address1"><?php echo Yii::t('app', 'Address 1'); ?><span style="color:red">*</span></label>
                                    <input type="text" name="Company[address1]" class="form-control" id="address1" required>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="address2"><?php echo Yii::t('app', 'Address 2'); ?><span style="color:red">*</span></label>
                                    <input type="text" name="Company[address2]" class="form-control" id="address2" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-4">
                                    <label for="city"><?php echo Yii::t('app', 'City'); ?><span style="color:red">*</span></label>
                                    <input type="text" name="Company[city]" class="form-control" id="city" required>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="state"><?php echo Yii::t('app', 'State'); ?><span style="color:red">*</span></label>
                                    <input type="text" name="Company[state]" class="form-control" id="state" required>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="pincode"><?php echo Yii::t('app', 'Pincode'); ?><span style="color:red">*</span></label>
                                    <input type="text" name="Company[pincode]" class="form-control" id="pincode" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-4">
                                    <label for="phone_number"><?php echo Yii::t('app', 'Phone Number'); ?><span style="color:red">*</span></label>
                                    <input type="text" name="Company[phone_number]" class="form-control" id="phone_number" required>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="mobile_number"><?php echo Yii::t('app', 'Mobile Number'); ?><span style="color:red">*</span></label>
                                    <input type="text" name="Company[mobile_number]" class="form-control" id="mobile_number" required>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="gst_number"><?php echo Yii::t('app', 'GST Number'); ?><span style="color:red">*</span></label>
                                    <input type="text" name="Company[gst_number]" class="form-control" id="gst_number" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-6 companyLogo">
                                    <label for="logo"><?php echo Yii::t('app', 'Logo'); ?></label>
                                    <?php 
                                        echo FileInput::widget([
                                            'name' => 'Company[logo]',
                                            'options' => ['accept' => 'image/*', 'id' => 'companyLogo'],
                                            'pluginOptions' => [
                                                'initialPreviewAsData'=>true,
                                                'showUpload' => false,
                                                'browseLabel' => '',
                                                'removeLabel' => '',
                                                'mainClass' => 'input-group-lg',
                                                'overwriteInitial' => true
                                            ]
                                        ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary saveData saveCompany" data-model='Company'><?php echo Yii::t('app', 'Save'); ?></button>
      </div>
    </div>
  </div>
</div>
