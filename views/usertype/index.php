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
        <?= Html::a(Yii::t('app', 'Create User Type'), ['create'], ['class' => 'btn btn-success']) ?>
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
