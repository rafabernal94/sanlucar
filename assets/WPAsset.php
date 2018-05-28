<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class WPAsset extends AssetBundle
{
    public $sourcePath = '@npm/waypoints';
    public $baseUrl = '@web';
    public $js = [
        'lib/jquery.waypoints.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
