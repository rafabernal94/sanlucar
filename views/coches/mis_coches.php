<?php
use yii\helpers\Html;

$this->title = 'Mis coches';
$this->params['breadcrumbs'][] = ['label' => 'Mi perfil', 'url' => ['usuarios/perfil', 'id' => Yii::$app->user->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

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
        <?php if(count($coches) > 0): ?>
            <div class="panel-group">
                <?php foreach ($coches as $coche): ?>
                    <?= $this->render('/coches/coche', [
                        'coche' => $coche
                    ]); ?>
                <?php endforeach ?>
            </div>
        <?php else: ?>
            <h4>No tienes coches asociados a tu perfil.</h4>
            <?= Html::a('Añadir coche',
                ['coches/crear'],
                ['class' => 'btn btn-success']
            ); ?>
        <?php endif ?>
    </div>
</div>
