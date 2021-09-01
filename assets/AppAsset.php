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
    public $baseUrl = '@web/../themes/material-dashboard';
    
    public $css = [
        'assets/css/material-dashboard.min.css',
        'assets/css/font-awesome.min.css',
        'assets/css/google-font.css',

        /**  Application css */
        'assets/css/application/application-core.css',
    ];
    public $js = [
        'assets/js/core/popper.min.js',
        'assets/js/core/bootstrap-material-design.min.js',
        'assets/js/plugins/perfect-scrollbar.jquery.min.js',
        'assets/js/plugins/moment.min.js',
        'assets/js/plugins/sweetalert2.js',
        'assets/js/plugins/jquery.validate.min.js',
        'assets/js/plugins/jquery.bootstrap-wizard.js',
        'assets/js/plugins/bootstrap-selectpicker.js',
        'assets/js/plugins/bootstrap-datetimepicker.min.js',
        'assets/js/plugins/jquery.dataTables.min.js',
        'assets/js/plugins/bootstrap-tagsinput.js',
        'assets/js/plugins/jasny-bootstrap.min.js',
        'assets/js/plugins/fullcalendar.min.js',
        'assets/js/plugins/jquery-jvectormap.js',
        'assets/js/plugins/nouislider.min.js',
        'assets/js/plugins/arrive.min.js',
        'assets/js/plugins/chartist.min.js',
        'assets/js/plugins/bootstrap-notify.js',
        'assets/js/material-dashboard.js',

        /**  Application js */
        'assets/js/application/application-core.js',
        'assets/js/application/weaver-loom.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
