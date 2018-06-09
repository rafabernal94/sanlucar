<?php

/* @var $this yii\web\View */
/* @var $model app\models\Trayectos */
/* @var $conductor app\models\Conductor */
/* @var $pref app\models\Preferencias */

use app\models\Coches;
use app\models\Usuarios;
use app\models\Solicitudes;
use app\helpers\Utiles;
use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\icons\Icon;

$this->title = 'Detalles';
$this->params['breadcrumbs'][] = ['label' => 'Mis trayectos', 'url' => ['trayectos/mis-trayectos']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/draw-detalles.js', [
    'position' => View::POS_HEAD,
    'depends' => [\yii\web\JqueryAsset::className()]
]);
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyAhfDqWQK52OS9wzjw5P6QE_ejpFTytrD4&libraries=places&callback=initMap');

$js = <<<EOT
$(function() {
    $.removeCookie('paypal_pasajero_id', { path: '/' });
    $('#modalButton').on('click', function() {
        $('#modalMapa').modal('show')
            .find('#modalContent');
    });
});
EOT;
$this->registerJs($js);
$url = Url::to(['solicitudes/crear']);
$url2 = Url::to(['solicitudes/aceptar']);
$js = <<<EOT
$(document).ready(function() {
    $('#btnSolicitar').on('click', function(e) {
        e.preventDefault();
        enviarAjax('$url', 'POST',
            {idTrayecto: $(this).siblings('#id-trayecto').val()},
            function(data) {
                if (data) {
                    var btn = $('<button class="btn btn-default" disabled>Solicitud de plaza enviada</button>');
                    $(this).replaceWith(btn);
                }
            }.bind(this)
        );
    });
    $('body').on('click', '.btnAceptarSolicitud', function(e) {
        e.preventDefault();
        enviarAjax('$url2', 'POST',
            {idSolicitud: $(this).siblings('#id-solicitud').val()},
            function(data) {
                $('#listaPasajeros').closest('.panel-default').html(data[0]);
                $('#listaSolicitudes').replaceWith(data[1]);
            }
        );
    });
});
EOT;
$this->registerJs($js);
?>
<?php if (Yii::$app->user->id === $conductor->id): ?>
    <?= Utiles::modal('Eliminar trayecto') ?>
<?php else: ?>
    <?= Utiles::modal('Retirarse del trayecto') ?>
<?php endif ?>

<div class="row">
    <div class="col-md-12">
        <ul class="list-group">
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-6 col-xs-12 mb-5">
                        <?= Html::hiddenInput('origen', $model->origen, ['id' => 'origen']) ?>
                        <?= Html::hiddenInput('destino', $model->destino, ['id' => 'destino']) ?>
                        <h3 class="mt-0"><strong>
                            <?php
                            $origen = explode(',', $model->origen)[0];
                            $destino = explode(',', $model->destino)[0];
                            ?>
                            <?= Html::encode($origen) . ' '
                            . Icon::show('long-arrow-right', ['class' => 'text-muted'])
                            . Html::encode($destino) ?>
                        </strong></h3>
                        <?php $hora = strtotime($model->fecha . 'UTC'); ?>
                        <?= Html::encode(
                            Yii::$app->formatter->asDate($model->fecha, 'long')
                            ) ?> a las <strong><?= date('H:i', $hora) ?></strong>
					</div>
                    <?php if (Yii::$app->user->id === $conductor->id): ?>
                        <?php if (!$model->haFinalizado()): ?>
        					<div class="col-md-6 col-xs-12 text-right">
                                <?= Html::a(Icon::show('pencil') . 'Modificar', [
                                        'trayectos/modificar', 'id' => $model->id
                                    ], [
                                        'class' => 'btn btn-primary',
                                    ]
                                ) ?>
                                <?php if ($model->totalPasajeros() === 0): ?>
                                    <?= Html::a(Icon::show('trash'). 'Eliminar',
                                        ['trayectos/eliminar', 'id' => $model->id],
                                        [
                                            'data-confirm' => '¿Estás seguro que quieres eliminar el trayecto?',
                                            'data-method' => 'post',
                                            'class' => 'btn btn-danger'
                                        ]
                                    ) ?>
                                <?php endif ?>
        					</div>
                        <?php endif ?>
                    <?php endif ?>
				</div>
			</li>
		</ul>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
  			<div class="panel-body">
                <div class="row pl-20">
                    <div class="col-xs-2 col-md-1" style="padding-top: 3px">
                        <?= date('H:i', $hora) ?>
                    </div>
                    <div class="col-xs-2 col-md-1">
                        <?= Icon::show('bullseye', ['class' => 'fa-2x text-primary']) ?>
                    </div>
                    <div class="col-xs-8 col-md-10 pl-0">
                        <h4 class="mt-5"><?= Html::encode($origen) ?></h4>
                    </div>
                </div>
                <div class="row pl-30">
                    <div class="col-xs-2 col-md-1 pt-5">
                    </div>
                    <div class="col-xs-2 col-md-1 pl-10">
                        <?= Icon::show('map-marker', ['class' => 'fa-2x text-primary']) ?>
                    </div>
                    <div class="col-md-8 pl-0">
                        <h4 class="mt-5"><?= Html::encode($destino) ?></h4>
                    </div>
                </div>
            </div>
            <div class="panel-footer text-center">
                <?= Html::button(Icon::show('map'). ' Ver trayecto en el mapa', [
                    'id' => 'modalButton',
                    'class' => 'btn btn-link',
                    'style' => 'padding: 0px'
                ]) ?>
            </div>
        </div>
        <div class="panel panel-default">
  			<div class="panel-heading">
                <h3 class="panel-title">Conductor</h3>
            </div>
  			<div class="panel-body">
                <div class="col-xs-6 col-md-3">
                    <?= Html::img(
                        $conductor->url_avatar, [
                            'class' => 'img-circle img-responsive',
                            'style' => 'width: 100px; height: 100px',
                        ]) ?>
                </div>
                <div class="col-xs-6 col-md-9 pl-0">
                    <h3 class="mt-10"><strong>
                        <?= Html::a(Html::encode($conductor->nombre)
                        . ' ' . Html::encode(
                            substr($conductor->apellido, 0, 1) . '.'
                        ), ['usuarios/perfil', 'id' => $conductor->id]) ?>
                    </strong></h3>
                    <h5>Usuario desde <?= Yii::$app->formatter->asDate(
                        $conductor->created_at) ?></h5>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
  			<div class="panel-heading">
                <h3 class="panel-title">Detalles y preferencias</h3>
            </div>
            <ul class="list-group">
    			<li class="list-group-item pb-0">
    				<div class="row">
    					<div class="col-xs-5 col-md-3">
    						<span><strong>Coche</strong></span>
    					</div>
    					<div class="col-xs-7 col-md-9">
    						<span><?php
                            if (($coche = Coches::findOne($conductor->coche_fav)) !== null): ?>
                                <p> <?= Html::encode($conductor->cocheFav->marca) . ' '
                                . Html::encode($conductor->cocheFav->modelo)
                                ?></p>
                            <?php else: ?>
                                No tiene coche favorito.
                                <?php if (Yii::$app->user->id === $conductor->id): ?>
                                    <?= Html::a(
                                        'Seleccionar coche favorito',
                                        ['coches/mis-coches', 'id' => $model->conductor_id],
                                        ['style' => 'font-size: 12px']
                                    ) ?>
                                <?php endif ?>
                            <?php endif ?></span>
    					</div>
    				</div>
    			</li>
    			<li class="list-group-item">
    				<div class="row">
    					<div class="col-xs-5 col-md-3">
    						<span><strong>Preferencias</strong></span>
    					</div>
    					<div class="col-xs-7 col-md-9 text-right pl-5">
                            <div class="row">
                                <?php
                                $img = '@web/images/';
                                $pref->musica ? $img .= 'check.svg' : $img .= 'prohibited.svg';
                                $array = [
                                    'class' => 'img-circle img-responsive',
                                    'style' => 'width: 20px; height: 28px',
                                ];
                                ?>
                                <div class="col-md-6 col-xs-6" style="display: flex">
                                    <?= Html::img($img, $array) ?>
                                    <span class="pt-5 pl-5">Música</span>
                                </div>
                                <?php
                                $img = '@web/images/';
                                $pref->ninos ? $img .= 'check.svg' : $img .= 'prohibited.svg';
                                ?>
                                <div class="col-md-6 col-xs-6" style="display: flex">
                                    <?= Html::img($img, $array) ?>
                                    <span class="pt-5 pl-5">Niños</span>
                                </div>
                            </div>
                            <div class="row">
                                <?php
                                $img = '@web/images/';
                                $pref->mascotas ? $img .= 'check.svg' : $img .= 'prohibited.svg';
                                ?>
                                <div class="col-md-6 col-xs-6" style="display: flex">
                                    <?= Html::img($img, $array) ?>
                                    <span class="pt-5 pl-5">Mascotas</span>
                                </div>
                                <?php
                                $img = '@web/images/';
                                $pref->fumar ? $img .= 'check.svg' : $img .= 'prohibited.svg';
                                ?>
                                <div class="col-md-6 col-xs-6" style="display: flex">
                                    <?= Html::img($img, $array) ?>
                                    <span class="pt-5 pl-5">Fumar</span>
                                </div>
                            </div>
    					</div>
    				</div>
    			</li>
            </ul>
		</div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
  			<div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6 col-md-6">
                        <h3 class="panel-title">Precio</h3>
                    </div>
                    <div class="col-xs-6 col-md-6 text-right">
                        <h3 class="panel-title">
                            <strong><?= Html::encode($model->precio) ?> €</strong>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <?= $this->render('lista_pasajeros', [
                'trayecto' => $model
            ]) ?>
            <?php $userActual = Usuarios::findOne(Yii::$app->user->id); ?>
            <?php $solicitud = Solicitudes::findOne([
                'usuario_id' => Yii::$app->user->id,
                'trayecto_id' => $model->id]
            ); ?>
            <?php if (Yii::$app->user->id !== $conductor->id
                    && !$userActual->esPasajero($model) && $solicitud === null
                    && $model->plazas >= 1 && !$model->haFinalizado()): ?>
                <div class="panel-footer text-center">
                    <?= Html::beginForm(
                        ['solicitudes/crear'],
                        'post'
                    ) ?>
                    <?= Html::hiddenInput('id-trayecto', $model->id, [
                        'id' => 'id-trayecto'
                        ]) ?>
                    <?= Html::submitButton(
                        'Solicitar plaza',
                        ['id' => 'btnSolicitar', 'class' => 'btn btn-success']
                    ) ?>
                    <?= Html::endForm() ?>
                </div>
            <?php endif ?>
            <?php if ($solicitud !== null && !$solicitud->estaAceptada($model->id)): ?>
                <div class="panel-footer text-center">
                    <?= Html::submitButton(
                        'Solicitud de plaza enviada',
                        [
                            'class' => 'btn btn-default',
                            'disabled' => 'disabled'
                        ]
                    ) ?>
                </div>
            <?php endif ?>
		</div>
    </div>
    <?php if (Yii::$app->user->id === $conductor->id): ?>
        <div class="col-md-4">
            <div class="panel panel-default">
      			<div class="panel-heading">
                    <h3 class="panel-title">Solicitudes de unión</h3>
                </div>
                <?= $this->render('lista_solicitudes', [
                    'trayecto' => $model
                ]) ?>
    		</div>
        </div>
    <?php endif ?>
</div>
<?php
    Modal::begin([
        'header' => '<span style="font-size: 24px">Resumen del trayecto</span>',
        'id' => 'modalMapa',
        'size' => 'modal-lg',
    ]);
    echo "<div id='modalContent'><div id='mapa' style='width:100%; height:400px'></div></div>";
    Modal::end();
?>
