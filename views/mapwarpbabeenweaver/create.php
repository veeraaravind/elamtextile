<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MapWarpBabeenWeaver */

$this->title = Yii::t('app', 'Create Map Warp Babeen Weaver');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Map Warp Babeen Weavers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="map-warp-babeen-weaver-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
