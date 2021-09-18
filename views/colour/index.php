<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\color\ColorInput;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ColourSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Colours');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="colour-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(
                Yii::t('app', 'Create Colour'), 
                ['create'], 
                [
                    'class' => 'btn btn-success createDataModal createColour',
                    'data-target' => "#colourModal",
                    'data-model' => "Colour"
                ]
            ) 
        ?>
    </p>

    <?php Pjax::begin(['id' => 'pjax-grid-view', 'options' => ['data-model' => 'Colour']]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'code',
            // Enable below fields only for advanced users
            // [
            //     'attribute' => 'status',
            //     'filter' => Html::dropDownList(
            //         'ColourSearch[status]', 
            //         isset($_GET['ColourSearch']['status']) ? $_GET['ColourSearch']['status'] : '', 
            //         ['' => 'Select Status'] + app\models\BaseModel::getStatusList(),
            //         [
            //             'class' => 'form-control'
            //         ]
            //     ),
            //     'format' => 'raw',
            //     'value' => function ($model) {
            //         return  $model->getStatus();
            //     },
            // ],

            $searchModel->gridAction()
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
<div class="modal fade bd-example-modal-lg" id="colourModal" role="dialog" aria-labelledby="colourLabel" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="colourLabel"><?php echo Yii::t('app', 'Colour'); ?></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id='colourForm'>
            <div class="colourDetails">
                <div class="col-md-12 mb-12">
                    <div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <div class="form-row">
                                <div class="col-md-4 mb-4">
                                    <label for="name"><?php echo Yii::t('app', 'Name'); ?><span style="color:red">*</span></label>
                                    <input type="text" name="Colour[name]" class="form-control" id="name" required>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="code"><?php echo Yii::t('app', 'Code'); ?><span style="color:red">*</span></label>
                                    <?php echo ColorInput::widget([
                                            'name' => 'Colour[code]',
                                            'options' => ['class' => 'form-control', 'id' => 'code', 'required' => true],
                                            'pluginOptions' => [
                                                'showInput' => false
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
        <button type="button" class="btn btn-primary saveData saveColour" data-model='Colour'><?php echo Yii::t('app', 'Save'); ?></button>
      </div>
    </div>
  </div>
</div>
