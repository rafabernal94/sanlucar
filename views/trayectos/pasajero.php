<?php
/* @var $pasajero app\models\Pasajeros */
/* @var $model app\models\Trayectos */

use yii\helpers\Html;

use kartik\icons\Icon;

$js = <<<EOT
$(document).ready(function() {
    $('.btn-paypal').on('click', function(e) {
        e.preventDefault();
        var pasajero_id = $(this).siblings('input[name="pasajero_id"]').val();
        $.cookie('paypal_pasajero_id', pasajero_id, {path: '/' });
    });
});
EOT;
$this->registerJs($js);
?>
<li class="list-group-item">
    <div class="row">
        <div class="col-xs-3 col-md-2">
            <?= Html::img(
                $pasajero->usuarioId->usuario->url_avatar, [
                    'class' => 'img-circle img-responsive',
                    'style' => 'width: 30px; height: 30px',
                ]) ?>
        </div>
        <div class="col-xs-5 col-md-6 pl-0 pt-5">
            <?= Html::a(Html::encode($pasajero->usuarioId->usuario->nombre
            . ' ' . substr($pasajero->usuarioId->usuario->apellido, 0, 1)) . '.',
            ['usuarios/perfil', 'id' => $pasajero->usuarioId->usuario->id]) ?>
        </div>
        <?php if ($pasajero->usuarioId->usuario->id === Yii::$app->user->id): ?>
            <?php if (!$model->haFinalizado()): ?>
                <div class="col-xs-4 col-md-4 text-right pt-5" style="display: inline-flex;">
                    <?= Html::a(
                        'Retirarse',
                        [
                            'pasajeros/eliminar',
                            'usuarioId' => $pasajero->usuarioId->usuario->id,
                            'trayectoId' => $model->id,
                        ],
                        [
                            'data-confirm' => '¿Estás seguro que quieres retirarte del trayecto? Si ya has realizado el pago, no podrás recuperar el importe.',
                            'data-method' => 'post',
                            'class' => 'btn btn-xs btn-danger',
                            'style' => 'margin-right: 5px',
                            'title' => 'Retirarse del trayecto'
                        ]
                    ) ?>
                    <?php if (!$pasajero->pagado): ?>
                        <?= $this->render('/paypal/_form', [
                            'trayecto' => $model,
                            'pasajero' => $pasajero
                        ]) ?>
                    <?php else: ?>
                        <?= Html::button(Icon::show('check'), [
                            'class' => 'btn btn-xs btn-success',
                            'disabled' => 'disabled',
                            'title' => 'Pago completado'
                        ]) ?>
                    <?php endif ?>
                </div>
            <?php endif ?>
        <?php endif ?>
    </div>
</li>
