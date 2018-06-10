<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Iniciar sesión';
$this->params['breadcrumbs'][] = $this->title;

$js = <<<EOT
$(document).ready(function() {
    $('#login-form').on('beforeSubmit', function() {
        $('.btn-success').text('Iniciando sesión');
        initBotonCargando('.btn-success');
    });
});
EOT;
$this->registerJs($js);
?>
<div class="site-login">
    <div class="col-md-12">
        <h3><strong><?= Html::encode($this->title) ?></strong></h3>
        <hr>
        <div class="col-md-offset-3 col-md-6">
            <div class="row">
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

                    <?= $form->field($model, 'rememberMe')->checkbox([])
                        ->label('Recuérdame') ?>

                    <div class="col-md-4 col-xs-6 pl-0">
                        <div class="form-group">
                            <?= Html::submitButton('Iniciar sesión', ['class' => 'btn btn-success btn-block', 'name' => 'login-button']) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="row">
                <hr>
                ¿No tienes cuenta?
                <?= Html::a('Regístrate', ['usuarios/registrar']); ?>
                <br>
                ¿Olvidaste tu contraseña?
                <?= Html::a('Restaurar', ['usuarios/recuperar-pass']); ?>
            </div>
        </div>
    </div>
</div>
