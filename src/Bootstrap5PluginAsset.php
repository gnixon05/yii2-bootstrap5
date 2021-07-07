<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace gnixon\bootstrap5;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Twitter bootstrap javascript files.
 */
class Bootstrap5PluginAsset extends AssetBundle
{
    public $sourcePath = '@tebs/bootstrap/dist';
    public $js = [
        'js/bootstrap.bundle.min.js',
    ];
    public $depends = [
        'yii\bootstrap5\Bootstrap5Asset',
    ];
}