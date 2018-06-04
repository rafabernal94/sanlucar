<?php
/* @var $solicitud app\models\Solicitudes */
/* @var $model app\models\Trayectos */

use yii\helpers\Html;

?>
<li class="list-group-item">
    <div class="row">
        <div class="col-xs-3 col-md-2">
            <?= Html::img(
                $solicitud->usuarioId->usuario->url_avatar, [
                    'class' => 'img-circle img-responsive',
                    'style' => 'width: 30px; height: 30px',
                ]) ?>
        </div>
        <div class="col-xs-3 col-md-4 pl-0" style="padding-top: 4px">
            <?= Html::a(Html::encode($solicitud->usuarioId->usuario->nombre
            . ' ' . substr($solicitud->usuarioId->usuario->apellido, 0, 1)) . '.',
            ['usuarios/perfil', 'id' => $solicitud->usuarioId->usuario->id]) ?>
        </div>
        <div class="col-xs-6 col-md-6 pt-5 text-right">
            <?php
            $array = [
                'class' => 'btn btn-xs btn-success btnAceptarSolicitud',
            ];
            if ($model->estaCompleto()) {
                $array = array_merge($array, ['disabled' => 'disabled']);
            }
            ?>
            <?= Html::beginForm(
                ['solicitudes/aceptar'],
                'post'
            ) ?>
            <?= Html::hiddenInput('id-solicitud', $solicitud->id, [
                'id' => 'id-solicitud'
                ]) ?>
            <?= Html::submitButton('Aceptar solicitud', $array) ?>
            <?= Html::endForm() ?>
        </div>
    </div>
</li>
