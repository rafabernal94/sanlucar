<?php
/* @var $trayecto app\models\Trayectos */

use yii\helpers\Html;

?>
<div class="panel-heading">
    <h3 class="panel-title text-center">
        <strong>
            Pasajeros -
            <?= Html::encode($trayecto->plazas) ?> plazas disponibles
        </strong>
    </h3>
</div>
<ul id="listaPasajeros" class="list-group">
<?php if (count($trayecto->pasajeros)): ?>
    <?php foreach ($trayecto->pasajeros as $pasajero): ?>
        <?= $this->render('pasajero', [
            'pasajero' => $pasajero,
        ]) ?>
    <?php endforeach ?>
<?php else: ?>
    <li class="list-group-item">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                Aún no hay pasajeros.
            </div>
        </div>
    </li>
<?php endif ?>
</ul>
