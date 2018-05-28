<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class CUAsset extends AssetBundle
{
    public $sourcePath = '@npm/counterup';
    public $baseUrl = '@web';
    public $js = [
        'jquery.counterup.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
