<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Types');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-type-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(
                Yii::t('app', 'Create User Type'), 
                ['create'], 
                [
                    'class' => 'btn btn-success createDataModal createUserType',
                    'data-target' => "#userTypeModal",
                    'data-model' => "UserType"
                ]
            ) ?>
    </p>

    <?php Pjax::begin(['id' => 'pjax-grid-view', 'options' => ['data-model' => 'UserType']]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'code',
            [
                'attribute' => 'status',
                'filter' => Html::dropDownList(
                    'UserTypeSearch[status]', 
                    isset($_GET['UserTypeSearch']['status']) ? $_GET['UserTypeSearch']['status'] : '', 
                    ['' => 'Select Status'] + app\models\BaseModel::getStatusList(),
                    [
                        'class' => 'form-control'
                    ]
                ),
                'format' => 'raw',
                'value' => function ($model) {
                    return  $model->getStatus();
                },
            ],
            $searchModel->gridAction()
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
<div class="modal fade bd-example-modal-lg" id="userTypeModal" role="dialog" aria-labelledby="userTypeLabel" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="userTypeLabel"><?php echo Yii::t('app', 'User Type'); ?></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id='userTypeForm'>
            <div class="userTypeDetails">
                <div class="col-md-12 mb-12">
                    <div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <div class="form-row">
                                <div class="col-md-4 mb-4">
                                    <label for="name"><?php echo Yii::t('app', 'Name'); ?><span style="color:red">*</span></label>
                                    <input type="text" name="UserType[name]" class="form-control" id="name" required>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="code"><?php echo Yii::t('app', 'Code'); ?><span style="color:red">*</span></label>
                                    <input type="text" name="UserType[code]" class="form-control" id="code" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary saveData saveUserType" data-model='UserType'><?php echo Yii::t('app', 'Save'); ?></button>
      </div>
    </div>
  </div>
</div>
