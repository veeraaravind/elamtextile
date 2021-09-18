<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SareeTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Saree Types');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saree-type-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(
                Yii::t('app', 'Create Saree Type'), 
                ['create'], 
                [
                    'class' => 'btn btn-success createDataModal createSareeType',
                    'data-toggle' => "modal",
                    'data-target' => "#sareeTypeModal",
                    'data-model' => "SareeType"
                ]
            ) ?>
    </p>

    <?php Pjax::begin(['id' => 'pjax-grid-view', 'options' => ['data-model' => 'SareeType']]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            $searchModel->gridAction()
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<div class="modal fade bd-example-modal-lg" id="sareeTypeModal" tabindex="-1" role="dialog" aria-labelledby="sareeTypeLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="sareeTypeLabel"><?php echo Yii::t('app', 'Saree Type')?></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id='sareeTypeForm'>
            <div class="form-row sareeDetails">
                <div class="col-md-4 mb-3">
                    <label for="sareeName"><?php echo Yii::t('app', 'Saree Name'); ?></label>
                    <input type="text" name="SareeType[name]" class="form-control" id="sareeName" required>
                </div>
            </div>
            <h3><?php echo Yii::t('app', 'Saree inventory cost'); ?></h3>
            <div class="form-row sareeInventory">
                <div class="col-md-4 mb-4">
                    <label for="yarnWeight"><?php echo Yii::t('app', 'Yarn Weight'); ?></label>
                    <input type="number" name="SareeType[yarn_weight]" min="0" placeholder="0.000" step="0.100" pattern="^\d+(?:\.\d{4,3})?$" class="form-control" id="yarnWeight">
                </div>
                <div class="col-md-4 mb-4">
                    <label for="jarigaiWeight"><?php echo Yii::t('app', 'Jarigai Weight'); ?></label>
                    <input type="number" name="SareeType[jarigai_weight]" min="0" placeholder="0.000" step="0.100" pattern="^\d+(?:\.\d{4,3})?$" class="form-control" id="jarigaiWeight">
                </div>
                <div class="col-md-4 mb-4">
                    <label for="babeenMeter"><?php echo Yii::t('app', 'Babeen Meter'); ?></label>
                    <input type="number" name="SareeType[babeen_meter]" min="0" placeholder="0.000" step="0.100" pattern="^\d+(?:\.\d{4,3})?$" class="form-control" id="babeenMeter">
                </div>
            </div>
            <h3><?php echo Yii::t('app', 'Weaver Fee'); ?></h3>
            <div class="form-row sareeWeaverFee">
                <div class="col-md-4 mb-4">
                    <label for="outHouseWeaver"><?php echo Yii::t('app', 'Outside Weaver'); ?></label>
                    <input type="number" name="SareeType[out_weaver_fee]" min="0" placeholder="0.00" step="1.00" pattern="^\d+(?:\.\d{5,2})?$" class="form-control" id="outHouseWeaver">
                </div>
                <div class="col-md-4 mb-4">
                    <label for="inHouseWeaver"><?php echo Yii::t('app', 'In-house Weaver'); ?></label>
                    <input type="number" name="SareeType[in_weaver_fee]" min="0" placeholder="0.00" step="1.00" pattern="^\d+(?:\.\d{5,2})?$" class="form-control" id="inHouseWeaver">
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary saveData saveSareeType" data-model='SareeType'><?php echo Yii::t('app', 'Save'); ?></button>
      </div>
    </div>
  </div>
</div>
