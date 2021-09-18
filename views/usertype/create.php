<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserType */

$this->title = Yii::t('app', 'Create User Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
