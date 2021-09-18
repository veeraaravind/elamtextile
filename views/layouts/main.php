<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use kartik\sidenav\SideNav;

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
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => sprintf('%s?r=site/index',Yii::$app->homeUrl),
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            (
                sprintf(
                    '<li class="nav-item dropdown">
                        <div class="btn-group language-switch" role="group">
                            <button type="button" class="btn btn-sm btn-secondary %s" data-value="en_US">English</button>
                            <button type="button" class="btn btn-sm btn-secondary %s" data-value="ta_IN">தமிழ்</button>
                        </div>
                    </li>',
                    Yii::$app->language == "en_US" ? "btn-warning active" : "",
                    Yii::$app->language == "ta_IN" ? "btn-warning active" : ""
                )
            ),
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                . Html::submitButton(
                    'Logout',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ),
            
        ],
    ]);
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="parent-container d-flex">
        <?php if (!Yii::$app->user->isGuest): ?>
            <div class="container leftMenuContainer" style="width: 18rem; position:fixed;">
                <div class="list-group">
                    <?php
                        $currentURL = urldecode(Yii::$app->request->url); 
                        echo SideNav::widget([
                            'type' => SideNav::TYPE_DEFAULT,
                            'encodeLabels' => false,
                            'heading' => sprintf('<i class="fas fa-bars"></i> %s', Yii::t('app', 'Menu')),
                            'items' => [
                                ['label' => Yii::t('app', 'Home'), 'icon' => 'home', 'url' => ['/site/index']],
                                ['label' => Yii::t('app', 'Master'), 'icon' => 'database', 'items' => [
                                    ['label' => Yii::t('app', 'Company'), 'icon' => 'building', 'url' => ['/company/index']],
                                    ['label' => Yii::t('app', 'Colour'), 'icon' => 'palette', 'url' => ['/colour/index']],
                                    ['label' => Yii::t('app', 'Bank'), 'icon' => 'university', 'url' => ['/bank/index']]
                                ]],
                                ['label' => Yii::t('app', 'Saree Type'), 'icon' => 'tshirt', 'url' => ['/saree-type/index']],
                                [
                                    'label' => Yii::t('app', 'Weaver'), 
                                    'icon' => 'user-ninja', 
                                    'url' => ['user/index', 'UserSearch[user_type_id]' => 3],
                                    'active' => $currentURL == urldecode(Yii::$app->urlManager->createUrl(
                                        ['user/index', 'UserSearch[user_type_id]' => 3]
                                    )) ? true : false
                                ],
                                [
                                    'label' => Yii::t('app', 'Warp Provider'), 
                                    'icon' => 'user-tie', 
                                    'url' => ['user/index', 'UserSearch[user_type_id]' => 4],
                                    'active' => $currentURL == urldecode(Yii::$app->urlManager->createUrl(
                                        ['user/index', 'UserSearch[user_type_id]' => 4]
                                    )) ? true : false
                                ],
                                [
                                    'label' => Yii::t('app', 'Babeen Provider'), 
                                    'icon' => 'user-secret', 
                                    'url' => ['user/index', 'UserSearch[user_type_id]' => 5],
                                    'active' => $currentURL == urldecode(Yii::$app->urlManager->createUrl(
                                        ['user/index', 'UserSearch[user_type_id]' => 5]
                                    )) ? true : false
                                ],
                            ],
                        ]);
                    ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="container mainContentContainer" style="margin-left:18rem;">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>

            <!-- Start Default view modal -->
            <div class="modal fade bd-example-modal-xl" id="defaultViewModal" tabindex="-1" role="dialog" aria-labelledby="defaultViewLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="defaultViewLabel"><?php echo Yii::t('app', 'View'); ?></h5>
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
                            <h5 class="modal-title" id="defaultDeleteLabel"><?php echo Yii::t('app', 'Delete'); ?></h5>
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
</main>

<footer class="footer mt-auto py-3 text-muted fixedFooter"> 
    <div class="container">
        <p class="float-right">&copy; ELM Software Solutions <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>