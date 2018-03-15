<?php
use yii\helpers\Html;


$this->title = 'Mis trayectos publicados';
$this->params['breadcrumbs'][] = ['label' => 'Mi perfil', 'url' => ['usuarios/perfil', 'id' => $usuario->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trayectos-index">
    <div class="col-md-offset-1 col-md-10">
        <div class="page-header mt-0">
            <h2><?= Html::encode('Mis trayectos publicados') ?></h2>
        </div>
        <?php if(count($trayectos) > 0): ?>
            <div class="panel-group">
                <?php foreach ($trayectos as $trayecto): ?>
                    <?= $this->render('/trayectos/trayecto', [
                        'trayecto' => $trayecto
                    ]) ?>
                <?php endforeach ?>
            </div>
        <?php else: ?>
            <h4>No tienes trayectos publicados</h4>
        <?php endif ?>
    </div>
</div>
