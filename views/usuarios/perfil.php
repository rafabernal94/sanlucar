<?php

use app\assets\CSAsset;

use app\helpers\Utiles;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Perfil de ' . $model->nombre . ' ' . substr($model->apellido, 0, 1) . '.';
$this->params['breadcrumbs'][] = ['label' => $this->title];

CSAsset::register($this);
$this->registerJsFile('@web/js/color-selector.js', [
	'depends' => [\yii\web\JqueryAsset::className()]
]);
?>
<?= Utiles::modal('Darse de baja') ?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default text-center">
			<?php
			$color = '#2E9AFE';
			if (Yii::$app->user->id === $model->id) {
				if (isset($_COOKIE['color'])) {
					$color = $_COOKIE['color'];
				}
			}
			?>
			<div class="panel-heading" style="background-color: <?= $color ?>">
				<div class="row">
					<div class="col-xs-2 col-md-5 text-left">
						<?php if (Yii::$app->user->id === $model->id): ?>
							<button class="btn btn-xs btn-default">
								<select id="colorselector">
								    <option value="1" data-color="#FE2E2E"></option>
								    <option value="2" data-color="#FE642E"></option>
								    <option value="3" data-color="#FE9A2E"></option>
								    <option value="4" data-color="#FACC2E"></option>
								    <option value="5" data-color="#F7FE2E"></option>
									<option value="6" data-color="#C8FE2E"></option>
									<option value="7" data-color="#9AFE2E"></option>
									<option value="8" data-color="#64FE2E"></option>
									<option value="9" data-color="#2EFE2E"></option>
									<option value="10" data-color="#2EFE64"></option>
									<option value="11" data-color="#2EFE9A"></option>
									<option value="12" data-color="#2EFEC8"></option>
								    <option value="13" data-color="#2EFEF7"></option>
									<option value="14" data-color="#2ECCFA"></option>
									<option value="15" data-color="#2E9AFE" selected="selected"></option>
									<option value="16" data-color="#2E64FE"></option>
									<option value="17" data-color="#2E2EFE"></option>
									<option value="18" data-color="#642EFE"></option>
									<option value="19" data-color="#9A2EFE"></option>
								    <option value="20" data-color="#CC2EFA"></option>
									<option value="21" data-color="#FE2EF7"></option>
									<option value="22" data-color="#FE2EC8"></option>
									<option value="23" data-color="#FE2E9A"></option>
									<option value="24" data-color="#FE2E64"></option>
									<option value="25" data-color="#A4A4A4"></option>
								</select>
							</button>
						<?php endif ?>
					</div>
					<div class="col-md-7 text-left hidden-xs">
						<?php
						if ($model->url_avatar !== null) {
							$fotoUrl = $model->url_avatar;
						} else {
							$fotoUrl = '@web/images/avatar-default.png';
						}
						?>
						<?= Html::img(
							$fotoUrl, [
								'class' => 'img-circle',
								'style' => 'height: 172px; width: 172px',
							]) ?>
					</div>
					<div class="col-xs-8 visible-xs">
						<?php
						if ($model->url_avatar !== null) {
							$fotoUrl = $model->url_avatar;
						} else {
							$fotoUrl = '@web/images/avatar-default.png';
						}
						?>
						<?= Html::img(
							$fotoUrl, [
								'class' => 'img-circle',
								'style' => 'height: 172px; width: 172px',
							]) ?>
					</div>
				</div>
			</div>
  			<div class="panel-body">
				<div class="col-md-10 col-xs-5 text-left">
					<h4><strong><?= Html::encode($model->nombre .
						' ' . substr($model->apellido, 0, 1)) ?>.</strong></h4>
					<h5>Aún no tienes valoraciones</h5>
				</div>
				<div class="col-md-2 col-xs-7 text-right">
					<?php if (Yii::$app->user->id === $model->id): ?>
						<?= Html::a(
							Html::tag('span', '', ['class' => 'glyphicon glyphicon-cog']) . ' Editar perfil',
							['usuarios/modificar', 'option' => 'infopersonal'],
							['class' => 'btn btn-primary btn-block']
						); ?>
						<?= Html::a(
							Html::tag('span', '', ['class' => 'glyphicon glyphicon-remove']) . ' Darse de baja',
							['usuarios/eliminar'],
							[
								'class' => 'btn btn-danger btn-block',
								'data-confirm' => '¿Estás seguro que quieres eliminar tu cuenta?',
								'data-method' => 'post',
							]
						); ?>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<ul class="list-group">
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-2 col-xs-6">
						<span><strong>Edad</strong></span>
					</div>
					<div class="col-md-10 col-xs-6 text-right">
						<span>23</span>
					</div>
				</div>
			</li>
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-5 col-xs-6">
						<span><strong>Usuario desde</strong></span>
					</div>
					<div class="col-md-7 col-xs-6 text-right">
						<span>
							<?= Html::encode(
								Yii::$app->formatter->asDate($model->created_at)
							) ?>
						</span>
					</div>
				</div>
			</li>
		</ul>
		<div class="panel panel-default">
  			<div class="panel-heading">
				<div class="row">
					<div class="col-md-6 col-xs-6">
						<strong>Mis coches</strong>
					</div>
					<?php if (Yii::$app->user->id === $model->id) : ?>
						<div class="col-md-6 col-xs-6 text-right">
							<?= Html::a('+', ['coches/crear'], [
								'class' => 'btn btn-xs btn-success',
								'title' => 'Añadir coche'
							]) ?>
						</div>
					<?php endif ?>
				</div>
			</div>
			<ul class="list-group">
				<?php if (count($model->usuarioId->coches)) : ?>
					<?php foreach ($model->usuarioId->coches as $coche) : ?>
						<li class="list-group-item">
							<div class="row">
								<div class="col-md-6 col-xs-6">
									<?= Html::encode($coche->marca . ' ' . $coche->modelo) ?>
								</div>
								<div class="col-md-6 col-xs-6 text-right">
									<?= Html::encode($coche->plazas) . ' plazas' ?>
								</div>
							</div>
						</li>
					<?php endforeach ?>
				<?php else : ?>
					<li class="list-group-item">
						<div class="row">
							<div class="col-md-12 col-xs-12">
								No tienes coches asociados
							</div>
						</div>
					</li>
				<?php endif ?>
			</ul>
		</div>
	</div>
	<div class="col-md-8">
		<div class="panel panel-default">
  			<div class="panel-heading"><strong>Sobre mi</strong></div>
  			<div class="panel-body"><?= Html::encode($model->biografia) ?></div>
		</div>
		<div class="panel panel-default">
  			<div class="panel-heading"><strong>Trayectos publicados</strong></div>
  			<div class="panel-body">
				<table class="table mb-0">
					<thead>
						<th>Salida</th>
						<th>Trayecto</th>
						<th>Plazas</th>
					</thead>
					<tbody>
						<?php foreach ($model->usuarioId->trayectos as $trayecto): ?>
							<tr>
								<?php $hora = strtotime($trayecto->fecha . 'UTC'); ?>
								<td><?= Html::encode(
									Yii::$app->formatter->asDate($trayecto->fecha))
									. ' a las '
									. Html::encode(date('H:i', $hora)) ?>
								</td>
								<?php
					            $origen = explode(',', $trayecto->origen)[0];
					            $destino = explode(',', $trayecto->destino)[0];
					            ?>
								<td><?= Html::a(Html::encode($origen)
									. " <span class='glyphicon glyphicon-arrow-right' aria-hidden='true'></span> "
									. Html::encode($destino)
									, ['trayectos/detalles', 'id' => $trayecto->id]) ?>
								</td>
								<td><?= Html::encode($trayecto->plazas) . ' disp.' ?></td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
