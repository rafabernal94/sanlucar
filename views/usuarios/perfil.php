<?php

use yii\helpers\Html;
use kartik\dialog\Dialog;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Perfil';
$this->params['breadcrumbs'][] = ['label' => 'Perfil'];

$js = <<<EOT
$('#btn-baja').on('click', function(e) {
	e.preventDefault();
    krajeeDialogCust.dialog();
});
EOT;
$this->registerJs($js);
?>
<?= Dialog::widget([
	'libName' => 'krajeeDialogCust',
	'overrideYiiConfirm' => true,
	'options' => [
		'size' => Dialog::SIZE_LARGE,
		'type' => Dialog::TYPE_DANGER,
		'title' => 'Darse de baja',
		'btnOKClass' => 'btn-danger',
		'btnOKLabel' => '<i class="glyphicon glyphicon-ok-sign"></i> Confirmar',
		'btnCancelLabel' =>'<i class="glyphicon glyphicon-remove-sign"></i> Cancelar',
	]
]); ?>
<div class="container">
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
    	    <div class="well">
				<div class="row">
					<div class="col-md-8">
	                    <h2>
							<strong>
								<?= Html::encode($model->nombre . ' ' . $model->apellido) ?>
							</strong>
						</h2>
	                    <p><strong>Email: </strong> <?= Html::encode($model->email) ?></p>
	                    <p><strong>Biografía: </strong> <?= Html::encode($model->biografia) ?></p>
	                </div>
					<?php
					if ($model->url_avatar !== null) {
						$fotoUrl = $model->url_avatar;
					} else {
						$fotoUrl = '@web/images/avatar-default.png';
					}
					?>
	                <div class="col-md-4 text-center">
	                    <?= Html::img(
							$fotoUrl, [
	                        	'class' => 'img-thumbnail img-responsive'
	                    	]) ?>
	                </div>
				</div>
                <?php if ($model->id === Yii::$app->user->id): ?>
					<hr>
					<div class="row">
	                    <div class="col-md-4 mb-5">
							<?= Html::a(
								Html::tag('span', '', ['class' => 'glyphicon glyphicon-cog']) . ' Modificar perfil',
								['usuarios/modificar', 'option' => 'infopersonal'],
								['class' => 'btn btn-primary btn-block']
							); ?>
	                    </div>
						<div class="col-md-4">
							<?= Html::a(
								Html::tag('span', '', ['class' => 'glyphicon glyphicon-remove']) . ' Darse de baja',
								['usuarios/eliminar'],
								[
									'id' => 'btn-baja',
									'class' => 'btn btn-danger btn-block',
									'data-confirm' => '¿Estás seguro que quieres eliminar tu cuenta?',
									'data-method' => 'post',
								]
							); ?>
	                    </div>
					</div>
                <?php endif ?>
    	    </div>
		</div>
	</div>
</div>
