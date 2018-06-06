<?php

use yii\helpers\Html;
use kartik\rating\StarRating;

/* @var $this yii\web\View */
/* @var $valoracion app\models\Valoraciones */

$css = <<<'CSS'
.mensaje { word-break: break-all; }
CSS;
$this->registerCss($css);
?>

<div class="col-md-6 col-xs-12">
    <div class="panel panel-warning mb-10">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-7 col-md-8">
                    <h3 class="panel-title">
                        Valoración de
                        <strong><?= Html::encode($valoracion->valorador->usuario->mostrarNombre()) ?></strong>
                    </h3>
                </div>
                <div class="col-xs-5 col-md-4 text-right">
                    <?= Html::encode(
                        Yii::$app->formatter->asRelativeTime($valoracion->created_at)
                    ) ?>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="mensaje col-md-12 col-xs-12">
                    <?= Html::encode($valoracion->texto) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-xs-12 text-right">
                    <?= StarRating::widget([
                        'name' => 'rating_1',
                        'value' => $valoracion->estrellas,
                        'pluginOptions' => [
                            'theme' => 'krajee-uni',
                            'disabled' => true,
                            'size' => 'xs',
                            'showClear' => false,
                            'showCaption' => false
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
