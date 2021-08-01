<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\bootstrap5;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Twitter bootstrap css files.
 */
class BootstrapAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap/dist';
    public $css = [
        'css/bootstrap.min.css',
    ];
}