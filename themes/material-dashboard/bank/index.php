<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BankSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Banks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Bank'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
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
                    'BankSearch[status]', 
                    isset($_GET['BankSearch']['status']) ? $_GET['BankSearch']['status'] : '', 
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
