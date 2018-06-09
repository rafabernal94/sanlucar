<?php

use yii\helpers\Html;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $trayecto app\models\Trayectos */
/* @var $pasajero app\models\Pasajeros */

?>

<form action="https://www.paypal.com/es/cgi-bin/webscr" method="post">

    <?= Html::hiddenInput('pasajero_id', $pasajero->id) ?>

    <?= Html::hiddenInput('cmd', '_xclick') ?>

    <!-- Email que recibirá el pago -->
    <?= Html::hiddenInput('business', Yii::$app->params['adminEmail']) ?>

    <!-- Nombre del producto  -->
    <?= Html::hiddenInput('item_name', 'Trayecto') ?>

    <!-- Tipo de moneda -->
    <?= Html::hiddenInput('currency_code', 'EUR') ?>

    <!-- Precio del producto -->
    <?= Html::hiddenInput('amount', $trayecto->precio) ?>

    <!-- Redirección al pagar -->
    <?= Html::hiddenInput('return', 'http://sanlucar.herokuapp.com/pasajeros/pagar') ?>

    <!-- Redirección al cancelar -->
    <?= Html::hiddenInput('cancel_return', 'http://sanlucar.herokuapp.com/pasajeros/cancelar') ?>

    <?= Html::submitButton(Icon::show('paypal'), [
        'title' => 'Pagar trayecto',
        'class' => 'btn btn-xs btn-primary btn-paypal'
    ]) ?>
</form>
