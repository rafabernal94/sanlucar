<?php

/* @var $this yii\web\View */
/* @var $trayectos yii\web\Trayectos */

use app\assets\CUAsset;
use app\assets\WPAsset;
use app\models\Usuarios;
use app\models\Trayectos;

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\icons\Icon;

$this->title = 'Inicio';
$this->registerJsFile('@web/js/live-chat.js');

CUAsset::register($this);
WPAsset::register($this);
$js = <<<EOT
$(document).ready(function() {
    $('.counter').counterUp({
        delay: 10,
        time: 300
    });
});
EOT;
$this->registerJs($js);

$css = <<<'CSS'
.object:hover {
    transform: scale(1.1);
    -webkit-transform: scale(1.1); /** Chrome & Safari **/
    -moz-transform: scale(1.1); /** Firefox **/
    -o-transform: scale(1.1); /** Opera **/
}
.object {
    transition: all 0.2s linear;
    -webkit-transition: all 0.2s linear; /** Chrome & Safari **/
    -moz-transition: all 0.2s linear; /** Firefox **/
    -o-transition: all 0.2s linear; /** Opera **/
}
.single_counter {
    background: #AD1519;
    color: #fff;
    border-radius: 20px;
}
video { border-radius: 20px; }
hr { border: 1px solid #AD1519; }
h3 { color: #AD1519; }
video { width: 100% }
CSS;
$this->registerCss($css);
$totalUsuarios = Usuarios::find()->count();
$totalTrayectos = Trayectos::find()->count();
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="object col-xs-12 col-md-3 text-center mt-60 hidden-xs">
                <div class="single_counter pt-30 pb-30">
                    <?= Icon::show('users', ['style' => 'font-size: 36px']) ?>
                    <h1 class="counter"><?= $totalUsuarios ?></h1>
                    <strong>USUARIOS REGISTRADOS</strong>
                </div>
            </div>
            <div class="col-md-6 mb-10">
                <video src="<?= Url::to('@web/videos/spot.mp4') ?>" autoplay loop muted></video>
            </div>
            <div class="object col-md-3 text-center mt-60 hidden-xs">
                <div class="single_counter pt-30 pb-30">
                    <?= Icon::show('map-signs', ['style' => 'font-size: 36px']) ?>
                    <h1 class="counter"><?= $totalTrayectos ?></h1>
                    <strong>TRAYECTOS PUBLICADOS</strong>
                </div>
            </div>
        </div>
        <div class="row visible-xs">
            <div class="col-xs-6 text-center pr-10">
                <div class="single_counter pt-20 pb-20">
                    <?= Icon::show('users', ['style' => 'font-size: 28px']) ?>
                    <h3 class="counter mt-10"><?= $totalUsuarios ?></h3>
                    <strong>USUARIOS REGISTRADOS</strong>
                </div>
            </div>
            <div class="col-xs-6 text-center pl-10">
                <div class="single_counter pt-20 pb-20">
                    <?= Icon::show('map-signs', ['style' => 'font-size: 28px']) ?>
                    <h3 class="counter mt-10"><?= $totalTrayectos ?></h3>
                    <strong>TRAYECTOS PUBLICADOS</strong>
                </div>
            </div>
        </div>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?php if(count($trayectos) > 0) : ?>
                <hr>
                <div class="row text-center">
                    <h3 class="mt-0 mb-20">Últimos trayectos publicados</h3>
                </div>
                <div class="row">
                    <div class="panel-group">
                        <?php foreach ($trayectos as $trayecto) : ?>
                            <div class="col-md-6">
                                <?= $this->render('/trayectos/trayecto', [
                                    'model' => $trayecto
                                ]); ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
                <div class="row text-center mt-10">
                    <h4><?= Html::a('Ver más', ['trayectos/buscar']) ?></h4>
                </div>
            <?php endif ?>
        <?php endif ?>
    </div>
</div>
