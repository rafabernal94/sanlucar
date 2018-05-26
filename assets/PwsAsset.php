<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class PwsAsset extends AssetBundle
{
    public $sourcePath = '@npm/pwstrength-bootstrap';
    public $baseUrl = '@web';
    public $js = [
        'examples/i18next.js',
        'dist/pwstrength-bootstrap.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
