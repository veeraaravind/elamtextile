<?php

/**
 * @package   yii2-grid
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2021
 * @version   3.3.7
 */

namespace kartik\grid;

use kartik\base\AssetBundle;

/**
 * Asset bundle for [[CheckboxColumn]] functionality of the [[GridView]] widget.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class CheckboxColumnAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->depends = array_merge(["kartik\\grid\\GridViewAsset"], $this->depends);
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('js', ['js/kv-grid-checkbox']);
        parent::init();
    }
}
