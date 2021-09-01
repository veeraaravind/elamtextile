<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\UserType;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?= Html::a(
                Yii::t('app', 'Create User'), 
                ['create'], 
                [
                    'class' => 'btn btn-success createDataModal createUser',
                    'data-toggle' => "modal",
                    'data-target' => "#userModal",
                    'data-model' => "User"
                ]
            ) ?>
    </p>

    <?php Pjax::begin(['id' => 'pjax-grid-view', 'options' => ['data-model' => 'User']]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'mobile_number',
            [
                'attribute' => 'bank_id',
                'filter' => Html::dropDownList(
                    'UserSearch[bank_id]', 
                    isset($_GET['UserSearch']['bank_id']) ? $_GET['UserSearch']['bank_id'] : '', 
                    ['' => Yii::t('app', 'Select Bank')] + ArrayHelper::map($bankList, 'id', 'name'),
                    [
                        'class' => 'form-control'
                    ]
                ), 
                'format'=>'raw', 
                'value' => function($model){
                    return $model->bank ? $model->bank->name : '';
                }
            ],
            'bank_account_number',
            'bank_ifsc_code',
            $searchModel->gridAction()
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<div class="modal fade bd-example-modal-lg" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="userLabel"><?php echo Yii::t('app', 'User'); ?></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id='userForm'>
            <div class="form-row userPersonalDetails">
                <div class="col-md-4 mb-4">
                    <input type="text" name="User[user_type_id]" class="form-control mandatoryField d-none" id="user_type_id" value="<?php echo $urlParam['UserSearch']['user_type_id']; ?>" required>
                    <label for="name"><?php echo Yii::t('app', 'Name'); ?></label>
                    <input type="text" name="User[name]" class="form-control" id="name" required>
                </div>
                <div class="col-md-4 mb-4">
                    <label for="mobileNumber"><?php echo Yii::t('app', 'Mobile Number'); ?></label>
                    <input type="text" name="User[mobile_number]" class="form-control" id="mobileNumber" required>
                </div>
                <div class="col-md-4 mb-4">
                    <label for="address"><?php echo Yii::t('app', 'Address'); ?></label>
                    <input type="text" name="User[address]" class="form-control" id="address">
                </div>
            </div>
            <?php if($urlParam['UserSearch']['user_type_id'] == UserType::$weaver): ?>                
                <h3><?php echo Yii::t('app', 'Loom Details'); ?></h3>
                <div class="loomDetails">
                    <div class="col-md-12 mb-12">
                        <div class="jumbotron jumbotron-fluid">
                            <div class="container">
                                <div class="form-row">
                                    <div class="col-md-4 mb-4">
                                        <label for="loomCount"><?php echo Yii::t('app', 'Loom Count'); ?></label>
                                        <input type="number" min="0" step="1" max="100" class="form-control" id="loomCount">
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <button type="button" class="btn btn-primary generateLoom"><?php echo Yii::t('app', 'Generate Loom'); ?></button>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label><?php echo Yii::t('app', 'Loom and Saree configuration'); ?></label>
                                    <div class="generatedLoom"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <h3><?php echo Yii::t('app', 'Bank Details'); ?></h3>
            <div class="form-row bankDetails">
                <div class="col-md-4 mb-4">
                    <label for="bank"><?php echo Yii::t('app', 'Bank'); ?></label>
                    <select class="custom-select form-control" id="bank" name="User[bank_id]">
                        <option value=""><?php echo Yii::t('app', 'Select Bank'); ?></option>
                        <?php foreach($bankList as $eachBank): ?>
                            <option value="<?php echo $eachBank['id']; ?>"><?php echo $eachBank['name']; ?></option>
                        <?php endforeach; ?>
                    </select>  
                </div>
                <div class="col-md-4 mb-4">
                    <label for="bank_account_number"><?php echo Yii::t('app', 'Bank Account Number'); ?></label>
                    <input type="text" name="User[bank_account_number]" class="form-control" id="bank_account_number">
                </div>
                <div class="col-md-4 mb-4">
                    <label for="bank_ifsc_code"><?php echo Yii::t('app', 'Bank IFSC Code'); ?></label>
                    <input type="text" name="User[bank_ifsc_code]" class="form-control" id="bank_ifsc_code">
                </div>
            </div>
            <h3><?php echo Yii::t('app', 'Login Credential'); ?></h3>
            <div class="form-row loginDetails">
                <div class="col-md-6 mb-3">
                    <label for="password"><?php echo Yii::t('app', 'Password'); ?></label>
                    <input type="text" name="User[password]" class="form-control" id="password">
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary saveData saveUser" data-model='User'><?php echo Yii::t('app', 'Save'); ?></button>
      </div>
    </div>
  </div>
</div>
