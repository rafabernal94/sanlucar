<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $valoraciones[] app\models\Valoraciones */
/* @var $usuario app\models\Usuarios */

$this->title = 'Valoraciones de ' . Html::encode($usuario->mostrarNombre());
$this->params['breadcrumbs'][] = ['label' => 'Mi perfil', 'url' => ['usuarios/perfil', 'id' => Yii::$app->user->id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="valoraciones">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 col-xs-6">
                <h3><strong><?= Html::encode($this->title) ?></strong></h3>
            </div>
        </div>
        <hr class="mt-10">
        <?php if(count($valoraciones) > 0): ?>
            <div class="panel-group">
                <div class="row">
                    <?php foreach ($valoraciones as $valoracion): ?>
                        <?= $this->render('valoracion', [
                            'valoracion' => $valoracion,
                        ]); ?>
                    <?php endforeach ?>
                </div>
            </div>
        <?php else: ?>
            <h4>No tienes valoraciones.</h4>
        <?php endif ?>
    </div>
</div>
