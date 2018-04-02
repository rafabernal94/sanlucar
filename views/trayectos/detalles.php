<?php

/* @var $this yii\web\View */
/* @var $model app\models\Trayectos */

use app\helpers\Utiles;
use yii\helpers\Html;

$this->title = 'Detalles';
$this->params['breadcrumbs'][] = ['label' => 'Mis trayectos', 'url' => ['trayectos/trayectos-publicados']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= Utiles::modal('Eliminar trayecto') ?>

<div class="trayectos-info">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <?= Html::a(Html::tag(
                            'span', '', ['class' => 'glyphicon glyphicon-user'])
                            . ' Ver ocupantes', '#'
                            ) ?>
                    </div>
                    <div class="col-md-4 text-center">
                        <?= Html::a(Html::tag(
                            'span', '', ['class' => 'glyphicon glyphicon-pencil'])
                            . ' Modificar', ['trayectos/modificar', 'id' => $model->id]
                        ) ?>
                    </div>
                    <div class="col-md-4 text-center">
                        <?= Html::a(Html::tag(
                            'span', '', ['class' => 'glyphicon glyphicon-trash'])
                            . ' Eliminar',
                            ['trayectos/eliminar', 'id' => $model->id],
                            [
                                'data-confirm' => '¿Estás seguro que quieres eliminar el trayecto?',
                                'data-method' => 'post',
                            ]
                        ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Itinerario</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-4 col-md-3">
                        <p><strong>Salida</strong></p>
                        <p><strong>Destino</strong></p>
                        <p><strong>Fecha</strong></p>
                    </div>
                    <div class="col-xs-8 col-md-9">
                        <p>
                            <span class="glyphicon glyphicon-map-marker"></span>
                            <?= Html::encode($model->origen) ?>
                        </p>
                        <p>
                            <span class="glyphicon glyphicon-map-marker"></span>
                            <?= Html::encode($model->destino) ?>
                        </p>
                        <?php $hora = strtotime($model->fecha . 'UTC'); ?>
                        <p>
                            <span class="glyphicon glyphicon-calendar"></span>
                            <?= Html::encode(
                                Yii::$app->formatter->asDate($model->fecha)
                                ) ?> - <?= date('H:i', $hora) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Plazas disponibles</h3>
            </div>
            <div class="panel-body">
                <h4><strong><?= Html::encode($model->plazas) ?></strong> plazas disponibles</h4>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Conductor</h3>
            </div>
            <div class="panel-body">
                <?php
                if ($model->conductor->usuario->url_avatar !== null) {
                    $fotoUrl = $model->conductor->usuario->url_avatar;
                } else {
                    $fotoUrl = '@web/images/avatar-default.png';
                }
                ?>
                <div class="col-xs-4 col-md-4">
                    <?= Html::img(
                        $fotoUrl, [
                            'class' => 'img-circle img-responsive',
                            'width' => '76'
                        ]) ?>
                </div>
                <div class="col-xs-8 col-md-8">
                    <h4>
                        <?= $model->conductor->usuario->nombre ?>
                        <?= substr($model->conductor->usuario->apellido, 0, 1) ?>
                    </h4>
                </div>
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <h4><strong>Actividad</strong></h4>
                    <p><?= $model->conductor->getTrayectos()->count() ?> viaje/s publicado/s</p>
                    <p>Usuario desde: <?= Yii::$app->formatter->asDate(
                        $model->conductor->usuario->created_at) ?></p>
                    <?= Html::a(
                        'Ver perfil público',
                        ['usuarios/perfil', 'id' => $model->conductor_id]
                    ) ?>
                </li>
            </ul>
        </div>
    </div>
</div>
