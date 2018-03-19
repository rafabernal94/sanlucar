<?php

/* @var $this yii\web\View */
/* @var $model app\models\Trayectos */

$this->title = 'Modificar trayecto';
$this->params['breadcrumbs'][] = ['label' => 'Mis trayectos', 'url' => ['trayectos/trayectos-publicados']];
$this->params['breadcrumbs'][] = 'Modificar trayecto';
?>
<div class="trayectos-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
