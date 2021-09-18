<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MapWarpBabeenWeaver */

$this->title = Yii::t('app', 'Update Map Warp Babeen Weaver: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Map Warp Babeen Weavers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="map-warp-babeen-weaver-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
