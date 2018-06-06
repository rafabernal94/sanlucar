<?php

/* @var $this yii\web\View */
/* @var $mensajes[] app\models\Mensajes */

?>

<?php foreach($mensajes as $mensaje): ?>
    <?= $this->render('mensaje', [
        'mensaje' => $mensaje
    ]) ?>
<?php endforeach ?>
