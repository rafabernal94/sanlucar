<?php

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Registrar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
