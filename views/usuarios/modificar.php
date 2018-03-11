<?php

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Modificar Perfil';
$this->params['breadcrumbs'][] = ['label' => 'Mi perfil', 'url' => ['usuarios/perfil', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar perfil';
?>
<div class="row">
    <div class="col-md-4">
        <?= $this->render('sidebar', [
            'model' => $model,
        ]) ?>
    </div>
    <div class="col-md-8">
        <?= $this->render('_form_' . $option, [
            'model' => $model,
        ]) ?>
    </div>
</div>
