<?php

/* @var $this yii\web\View */
/* @var $model app\models\Trayectos */

$this->title = 'Publicar trayecto';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trayectos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
