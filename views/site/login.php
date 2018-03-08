<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Iniciar sesión';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="col-md-offset-3 col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title text-center">
                    <h4><?= Html::encode($this->title) ?></h4>
                </div>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                ]); ?>

                    <?= $form->field($model, 'email')
                        ->textInput(['autofocus' => true])
                        ->input('email', ['placeholder' => 'Email'])
                        ->label(false) ?>

                    <?= $form->field($model, 'password')
                        ->passwordInput()
                        ->input('password', ['placeholder' => 'Contraseña'])
                        ->label(false) ?>

                    <?= $form->field($model, 'rememberMe')->checkbox([]) ?>

                    <div class="col-md-offset-4 col-md-4">
                        <div class="form-group">
                            <?= Html::submitButton('Iniciar sesión', ['class' => 'btn btn-success btn-block', 'name' => 'login-button']) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p>
                            ¿No tienes cuenta?
                            <?= Html::a('Registrarse', ['usuarios/registrar']); ?>
                        </p>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
