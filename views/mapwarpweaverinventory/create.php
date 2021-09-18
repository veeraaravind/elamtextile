<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MapWarpWeaverInventory */

$this->title = Yii::t('app', 'Create Map Warp Weaver Inventory');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Map Warp Weaver Inventories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="map-warp-weaver-inventory-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
