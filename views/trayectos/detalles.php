<?php

/* @var $this yii\web\View */
/* @var $model app\models\Trayectos */
/* @var $conductor app\models\Conductor */
/* @var $pref app\models\Preferencias */

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
        <div class="panel panel-default">
  			<div class="panel-heading">
                <h3 class="panel-title">Preferencias</h3>
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="row">
                        <?php
                        $img = '@web/images/';
                        $pref->musica ? $img .= 'check.svg' : $img .= 'prohibited.svg';
                        ?>
                        <div class="col-md-6 col-xs-6" style="display: flex">
                            <?= Html::img($img, [
                                    'class' => 'img-circle img-responsive',
                                    'style' => 'width: 28px; height: 28px',
                            ]) ?>
                            <span class="pt-5">Música</span>
                        </div>
                        <?php
                        $img = '@web/images/';
                        $pref->ninos ? $img .= 'check.svg' : $img .= 'prohibited.svg';
                        ?>
                        <div class="col-md-6 col-xs-6" style="display: flex">
                            <?= Html::img($img, [
                                    'class' => 'img-circle img-responsive',
                                    'style' => 'width: 28px; height: 28px',
                            ]) ?>
                            <span class="pt-5">Niños</span>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        $img = '@web/images/';
                        $pref->mascotas ? $img .= 'check.svg' : $img .= 'prohibited.svg';
                        ?>
                        <div class="col-md-6 col-xs-6" style="display: flex">
                            <?= Html::img($img, [
                                    'class' => 'img-circle img-responsive',
                                    'style' => 'width: 28px; height: 28px',
                            ]) ?>
                            <span class="pt-5">Mascotas</span>
                        </div>
                        <?php
                        $img = '@web/images/';
                        $pref->fumar ? $img .= 'check.svg' : $img .= 'prohibited.svg';
                        ?>
                        <div class="col-md-6 col-xs-6" style="display: flex">
                            <?= Html::img($img, [
                                    'class' => 'img-circle img-responsive',
                                    'style' => 'width: 28px; height: 28px',
                            ]) ?>
                            <span class="pt-5">Fumar</span>
                        </div>
                    </div>
                </li>
            </ul>
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
                <div class="col-xs-4 col-md-4">
                    <?= Html::img(
                        $conductor->url_avatar, [
                            'class' => 'img-circle img-responsive',
                            'style' => 'width: 76px; height: 76px',
                        ]) ?>
                </div>
                <div class="col-xs-8 col-md-8">
                    <h4><strong>
                        <?= Html::encode($conductor->nombre)
                        . ' ' . Html::encode(
                            substr($conductor->apellido, 0, 1)
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
                        $conductor->created_at) ?></p>
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
