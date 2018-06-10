<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $mensajes[] app\models\Mensajes */

?>
<hr class="mb-10 mt-10">
<div class="row">
    <div class="col-xs-3 col-md-1">
        <?= Html::img(
            $mensaje->usuarioId->usuario->url_avatar , [
                'class' => 'img-circle',
                'style' => 'width: 40px',
            ]) ?>
    </div>
    <div class="col-xs-9 col-md-8">
        <?= $mensaje->mensaje ?>
    </div>
    <div class="col-md-3 hidden-xs">
        <?= Yii::$app->formatter->asRelativeTime($mensaje->created_at) ?>
    </div>
</div>
