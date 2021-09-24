<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/application/application-core.css',
        'css/application/application-pagination.css',
        'css/font-awesome.min.css',
        'css/google-font.css',
        'css/dataTables.bootstrap.min.css',
    ];
    public $js = [
        'js/plugins/perfect-scrollbar.jquery.min.js',
        'js/plugins/moment.min.js',
        'js/plugins/sweetalert2.js',
        'js/plugins/jquery.validate.min.js',
        'js/plugins/jquery.bootstrap-wizard.js',
        'js/plugins/bootstrap-datetimepicker.min.js',
        'js/plugins/jquery.dataTables.min.js',
        'js/plugins/bootstrap-tagsinput.js',
        //'js/plugins/jasny-bootstrap.min.js',
        'js/plugins/fullcalendar.min.js',
        'js/plugins/jquery-jvectormap.js',
        'js/plugins/nouislider.min.js',
        'js/plugins/arrive.min.js',
        'js/plugins/chartist.min.js',
        'js/plugins/bootstrap-notify.js',
        
        /** Application js */
        'js/application/application-core.js',
        'js/application/weaver-loom.js',
        'js/application/warp-provider.js',
        'js/application/babeen-provider.js',
        'js/application/weaver-detailed-view.js',
        'js/application/reports.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
