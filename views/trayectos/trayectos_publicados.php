<?php
use app\helpers\Utiles;

use yii\helpers\Html;

$this->title = 'Mis trayectos publicados';
$this->params['breadcrumbs'][] = ['label' => 'Mi perfil', 'url' => ['usuarios/perfil', 'id' => $usuario->id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= Utiles::modal('Eliminar trayecto') ?>

<div class="trayectos-create">
    <div class="col-md-12">
        <h3><strong><?= Html::encode($this->title) ?></strong></h3>
        <hr>
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
