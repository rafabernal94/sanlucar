<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class CSAsset extends AssetBundle
{
    public $sourcePath = '@npm/bootstrap-colorselector';
    public $baseUrl = '@web';
    public $css = [
        'dist/bootstrap-colorselector.min.css',
    ];
    public $js = [
        'dist/bootstrap-colorselector.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
