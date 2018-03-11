<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Perfil';
$this->params['breadcrumbs'][] = ['label' => 'Perfil'];
?>
<div class="container">
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
    	    <div class="well profile">
                <div class="col-md-12">
                    <div class="col-md-9">
                        <h2>
							<strong>
								<?= Html::encode($model->nombre . ' ' . $model->apellido) ?>
							</strong>
						</h2>
                        <p><strong>Email: </strong> <?= Html::encode($model->email) ?></p>
                        <p><strong>Biografía: </strong> <?= Html::encode($model->biografia) ?></p>
                    </div>
                    <div class="col-md-3 text-center">
                        <?= Html::img('@web/images/avatar-default.png', [
                            'class' => 'img-rounded img-responsive'
                        ]) ?>
                    </div>
                </div>
                <?php if ($model->id === Yii::$app->user->id): ?>
                    <div class="col-md-12 divider">
                        <div class="col-md-4">
							<?= Html::a(
								Html::tag('span','',['class' => 'glyphicon glyphicon-cog']) . ' Modificar perfil',
								['usuarios/modificar', 'option' => 'infopersonal'],
								['class' => 'btn btn-primary btn-block']
							); ?>
                        </div>
                    </div>
                <?php endif ?>
    	    </div>
		</div>
	</div>
</div>
