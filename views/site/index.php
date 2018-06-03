<?php

/* @var $this yii\web\View */
use app\assets\CUAsset;
use app\assets\WPAsset;
use yii\helpers\Url;
use kartik\icons\Icon;

$this->title = 'Inicio';
$this->registerJsFile('@web/js/live-chat.js');

CUAsset::register($this);
WPAsset::register($this);
$js = <<<EOT
$(document).ready(function() {
    $('.counter').counterUp({
        delay: 10,
        time: 2000
    });
});
EOT;
$this->registerJs($js);

$css = <<<'CSS'
.derecha:hover {
    transform: rotate(-360deg);
    -webkit-transform: rotate(-360deg); /** Chrome & Safari **/
    -moz-transform: rotate(-360deg); /** Firefox **/
    -o-transform: rotate(-360deg); /** Opera **/
}
.izquierda:hover {
    transform: rotate(360deg);
    -webkit-transform: rotate(360deg); /** Chrome & Safari **/
    -moz-transform: rotate(360deg); /** Firefox **/
    -o-transform: rotate(360deg); /** Opera **/
}
.object {
    transition: all 1s linear;
    -webkit-transition: all 1s linear; /** Chrome & Safari **/
    -moz-transition: all 1s linear; /** Firefox **/
    -o-transition: all 1s linear; /** Opera **/
}
.single_counter {
    background: #AD1519;
    color: #fff;
    border-radius: 20px;
}
video {
    border-radius: 20px;
}
CSS;
$this->registerCss($css);
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="izquierda object col-xs-12 col-md-3 text-center mt-60 hidden-xs">
                <div class="single_counter pt-30 pb-30">
                    <?= Icon::show('users', ['style' => 'font-size: 36px']) ?>
                    <h1 class="counter">220</h1>
                    <strong>USUARIOS REGISTRADOS</strong>
                </div>
            </div>
            <div class="col-md-6 mb-10">
                <video width="100%" src="<?= Url::to('@web/videos/spot.mp4') ?>" autoplay loop muted></video>
            </div>
            <div class="derecha object col-md-3 text-center mt-60 hidden-xs">
                <div class="single_counter pt-30 pb-30">
                    <?= Icon::show('map-signs', ['style' => 'font-size: 36px']) ?>
                    <h1 class="counter">70</h1>
                    <strong>TRAYECTOS PUBLICADOS</strong>
                </div>
            </div>
        </div>
        <div class="row visible-xs">
            <div class="col-xs-6 text-center pr-10">
                <div class="single_counter pt-20 pb-20">
                    <?= Icon::show('users', ['style' => 'font-size: 28px']) ?>
                    <h3 class="counter mt-10">220</h3>
                    <strong>USUARIOS REGISTRADOS</strong>
                </div>
            </div>
            <div class="col-xs-6 text-center pl-10">
                <div class="single_counter pt-20 pb-20">
                    <?= Icon::show('map-signs', ['style' => 'font-size: 28px']) ?>
                    <h3 class="counter mt-10">70</h3>
                    <strong>TRAYECTOS PUBLICADOS</strong>
                </div>
            </div>
        </div>
    </div>
</div>
