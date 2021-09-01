<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use yii\bootstrap4\Html;
use app\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="">
<?php $this->beginBody() ?>
<div class="wrapper ">
    <?php echo $this->render('left-panel'); ?>
    <div class="main-panel">
    <?php echo $this->render('top-panel'); ?>
        <div class="content">
            <div class="container-fluid">
                <?= Alert::widget() ?>                
                <?= $content ?>

                <!-- Start Default view modal -->
                <div class="modal fade bd-example-modal-lg" id="defaultViewModal" tabindex="-1" role="dialog" aria-labelledby="defaultViewLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="defaultViewLabel"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table id="defaultViewDisplayTable" class="table table-striped table-bordered detail-view">
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end Default view modal -->

                <!-- Start Default delete modal -->
                <div class="modal fade bd-example-modal-lg" id="defaultDeleteModal" tabindex="-1" role="dialog" aria-labelledby="defaultDeleteLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="defaultDeleteLabel"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p><?php echo Yii::t('app', 'Are you sure you want to delete this item?'); ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger deleteData"><?php echo Yii::t('app', 'Delete');?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end Default view modal -->

            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
