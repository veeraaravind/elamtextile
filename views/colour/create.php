<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Colour */

$this->title = Yii::t('app', 'Create Colour');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Colours'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="colour-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
