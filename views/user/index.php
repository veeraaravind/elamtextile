<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\UserType;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$userTypeName = UserType::getUserType([$_GET['UserSearch']['user_type_id']]);

$this->title = Yii::t('app', $userTypeName);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?= Html::a(
                Yii::t('app', sprintf('Create %s', $userTypeName)), 
                ['create'], 
                [
                    'class' => 'btn btn-success createDataModal createUser',
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

            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->name, ['/user/detailed-view', 'id' => $data->id]);
                },
            ],
            'mobile_number',
            [
                'attribute' => 'bank_id',
                'filter' => Select2::widget(
                    [
                        'bsVersion' => '4.x',
                        'model' => $searchModel,
                        'attribute' => 'bank_id',
                        'size' => Select2::MEDIUM,
                        'data' =>  ['' => Yii::t('app', 'Select Bank')] + ArrayHelper::map($bankList, 'id', 'name'),
                        'pluginOptions' => ['width' => '200px']
                    ]
                ),
                'format'=>'raw', 
                'value' => function($model){
                    return $model->bank ? $model->bank->name : '';
                }
            ],
            'bank_account_number',
            'bank_ifsc_code',
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{detailed-view}',
                'buttons'  => [
                    'detailed-view'   => function ($url, $model) {
                        return Html::a('<i class="fa fa-eye gridActionIcon"></i>', $url, ['title' => 'Detailed View']);
                    }
                ]
            ]
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<?php 
    echo $this->render(
        'user_creation_modal', 
        [
            'userTypeId' => $urlParam['UserSearch']['user_type_id'],
            'bankList' => $bankList,
            'can_show_loom_details' => UserType::isWeaver($urlParam['UserSearch']['user_type_id'])
        ]
    );
?>

<script type="text/javascript">
    var sareeTypeList = <?php echo json_encode($sareeTypeList); ?>;
</script>
