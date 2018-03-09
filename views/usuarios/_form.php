<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
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
                <?php $form = ActiveForm::begin(); ?>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'nombre')
                        ->textInput(['maxlength' => true, 'placeholder' => 'Nombre'])
                        ->label(false) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'apellido')
                        ->textInput(['maxlength' => true, 'placeholder' => 'Apellido'])
                        ->label(false) ?>
                    </div>
                </div>
                <?= $form->field($model, 'email', ['enableAjaxValidation' => true])
                ->textInput(['maxlength' => true, 'placeholder' => 'Correo electrónico'])
                ->label(false) ?>

                <?= $form->field($model, 'password')
                ->passwordInput(['maxlength' => true, 'placeholder' => 'Contraseña'])
                ->label(false) ?>

                <?= $form->field($model, 'passwordRepeat')
                ->passwordInput(['maxlength' => true, 'placeholder' => 'Confirma tu contraseña'])
                ->label(false) ?>

                <div class="col-md-offset-4 col-md-4">
                    <div class="form-group">
                        <?= Html::submitButton('Registrarse', ['class' => 'btn btn-success btn-block']) ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <p>
                        ¿Ya tienes cuenta?
                        <?= Html::a('Iniciar sesión', ['site/login']); ?>
                    </p>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
