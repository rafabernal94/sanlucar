<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
?>
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
    ->passwordInput(['maxlength' => true, 'placeholder' => 'Confirmar contraseña'])
    ->label(false) ?>

    <div class="col-md-3 col-xs-6 pl-0">
        <div class="form-group">
            <?= Html::submitButton('Registrarse', ['class' => 'btn btn-success btn-block']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
