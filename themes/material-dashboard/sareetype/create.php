<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SareeType */

$this->title = Yii::t('app', 'Create Saree Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Saree Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="saree-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
