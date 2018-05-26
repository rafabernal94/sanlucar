<?php

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
use app\assets\PwsAsset;

use yii\helpers\Html;


$this->title = 'Regístrate';
$this->params['breadcrumbs'][] = $this->title;

PwsAsset::register($this);
$js = <<<EOT
$(document).ready(function() {
    "use strict";
    i18next.init({
        lng: 'es',
        resources: {
            es: {
                translation: {
                    "veryWeak": "Muy Débil",
                    "weak": "Débil",
                    "normal": "Normal",
                    "medium": "Media",
                    "strong": "Fuerte",
                    "veryStrong": "Muy Fuerte",
                }
            }
        }
    }, function () {
        var options = {};
        options.ui = {
            container: "#pwd-container",
            showVerdictsInsideProgressBar: true,
            viewports: {
                progress: ".pwstrength_viewport_progress"
            },
            progressBarExtraCssClasses: "progress-bar-striped active"
        };
        $('#password').pwstrength(options);
    });
});
EOT;
$this->registerJs($js);
?>
<div class="usuarios-registrar">
    <div class="col-md-12">
        <h3><strong><?= Html::encode($this->title) ?></strong></h3>
        <hr>
        <div class="col-md-offset-3 col-md-6">
            <div class="row">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
            <div class="row">
                <hr>
                ¿Ya tienes cuenta?
                <?= Html::a('Iniciar sesión', ['site/login']); ?>
            </div>
        </div>
    </div>
</div>
