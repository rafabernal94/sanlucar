<?php
/* @var $pasajero app\models\Pasajeros */
/* @var $model app\models\Trayectos */

use yii\helpers\Html;

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
        <div class="col-xs-9 col-md-4 pl-0 pt-5">
            <?= Html::a(Html::encode($pasajero->usuarioId->usuario->nombre
            . ' ' . substr($pasajero->usuarioId->usuario->apellido, 0, 1)) . '.',
            ['usuarios/perfil', 'id' => $pasajero->usuarioId->usuario->id]) ?>
        </div>
        <?php if ($pasajero->usuarioId->usuario->id === Yii::$app->user->id): ?>
            <?php if (!$model->haFinalizado()): ?>
                <div class="col-md-6 text-right pt-5">
                    <?= Html::a(
                        'Retirarse',
                        [
                            'pasajeros/eliminar',
                            'usuarioId' => $pasajero->usuarioId->usuario->id,
                                'trayectoId' => $model->id,
                        ],
                        [
                            'data-confirm' => '¿Estás seguro que quieres retirarte del trayecto? Perderás el importe pagado.',
                            'data-method' => 'post',
                            'class' => 'btn btn-xs btn-danger'
                        ]
                    ) ?>
                </div>
            <?php endif ?>
        <?php endif ?>
    </div>
</li>
