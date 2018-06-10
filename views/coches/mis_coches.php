<?php
use app\helpers\Utiles;

use yii\helpers\Html;

$this->title = 'Mis coches';
$this->params['breadcrumbs'][] = ['label' => 'Mi perfil', 'url' => ['usuarios/perfil', 'id' => Yii::$app->user->id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= Utiles::modal('Eliminar coche') ?>
<div class="mis-coches">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 col-xs-6">
                <h3><strong><?= Html::encode($this->title) ?></strong></h3>
            </div>
            <div class="col-md-6 col-xs-6 text-right">
                <?= Html::a('Añadir coche',
                    ['coches/crear'],
                    ['class' => 'btn btn-success mt-20']
                ); ?>
            </div>
        </div>
        <hr class="mt-10">
        <span class="label label-warning">Marca como favorito el coche que utilizarás para realizar tus trayectos.</span>
        <?php if(count($coches) > 0): ?>
            <div class="panel-group mt-10">
                <div class="row">
                    <?php foreach ($coches as $coche): ?>
                        <?= $this->render('/coches/coche', [
                            'coche' => $coche
                        ]); ?>
                    <?php endforeach ?>
                </div>
            </div>
        <?php else: ?>
            <h4>No tienes coches asociados a tu perfil.</h4>
        <?php endif ?>
    </div>
</div>
