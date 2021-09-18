<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MapWeaverInventory */

$this->title = Yii::t('app', 'Create Map Weaver Inventory');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Map Weaver Inventories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="map-weaver-inventory-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
