<?php
/* @var $trayecto app\models\Trayectos */

?>
<?php $solicitudesSinAceptar = $trayecto->getSolicitudes()
    ->where(['aceptada' => false])
    ->all(); ?>

<ul id="listaSolicitudes" class="list-group">
<?php if (count($solicitudesSinAceptar)): ?>
    <?php foreach ($solicitudesSinAceptar as $solicitud): ?>
        <?= $this->render('solicitud', [
            'solicitud' => $solicitud,
        ]) ?>
    <?php endforeach ?>
<?php else: ?>
    <li class="list-group-item">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                No tienes solicitudes pendientes.
            </div>
        </div>
    </li>
<?php endif ?>
</ul>
