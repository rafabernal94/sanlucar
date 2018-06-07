<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class NJSAsset extends AssetBundle
{
    public $sourcePath = '@bower/notifyjs';
    public $baseUrl = '@web';
    public $js = [
        'dist/notify.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
