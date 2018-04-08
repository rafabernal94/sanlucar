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

<div class="row">
    <div class="col-md-12">
        <ul class="list-group">
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-6 col-xs-6">
                        <h4><strong>
                            <?= Html::encode($model->origen)
                            . " <span class='glyphicon glyphicon-arrow-right' aria-hidden='true'></span> "
                            . Html::encode($model->destino) ?>
                        </strong></h4>
					</div>

                    <?php if (Yii::$app->user->id === $model->conductor->id): ?>
    					<div class="col-md-6 col-xs-6 text-right">
                            <?= Html::a(
                                'Editar el trayecto', [
                                    'trayectos/modificar', 'id' => $model->id
                                ], [
                                    'class' => 'btn btn-primary',
                                ]
                            ) ?>
                            <?= Html::a(
                                'Eliminar',
                                ['trayectos/eliminar', 'id' => $model->id],
                                [
                                    'data-confirm' => '¿Estás seguro que quieres eliminar el trayecto?',
                                    'data-method' => 'post',
                                    'class' => 'btn btn-danger'
                                ]
                            ) ?>
    					</div>
                    <?php endif ?>
				</div>
			</li>
		</ul>
    </div>
    <div class="col-md-8">
        <div class="panel panel-default">
  			<div class="panel-heading"><strong>Itinerario</strong></div>
  			<div class="panel-body">
                <div class="row">
                    <div class="col-xs-4 col-md-3">
                        <p><strong>Salida</strong></p>
                        <p><strong>Destino</strong></p>
                        <p><strong>Fecha</strong></p>
                    </div>
                    <div class="col-xs-8 col-md-9">
                        <p>
                            <span class="glyphicon glyphicon-record text-primary"></span>
                            <?= Html::encode($model->origen) ?>
                        </p>
                        <p>
                            <span class="glyphicon glyphicon-map-marker text-primary"></span>
                            <?= Html::encode($model->destino) ?>
                        </p>
                        <?php $hora = strtotime($model->fecha . 'UTC'); ?>
                        <p>
                            <span class="glyphicon glyphicon-calendar text-primary"></span>
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
  			<div class="panel-heading"><strong>Plazas disponibles</strong></div>
  			<div class="panel-body">
                <h4><strong><?= Html::encode($model->plazas) ?></strong> plazas disponibles</h4>
            </div>
		</div>
        <div class="panel panel-default">
  			<div class="panel-heading"><strong>Conductor</strong></div>
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
                            'style' => 'width: 76px; height: 76px',
                        ]) ?>
                </div>
                <div class="col-xs-8 col-md-8">
                    <h4><strong>
                        <?= Html::encode($model->conductor->usuario->nombre)
                        . ' ' . Html::encode(
                            substr($model->conductor->usuario->apellido, 0, 1)
                        ) ?>
                    </strong></h4>
                    <h5>23 años</h5>
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
</div>
