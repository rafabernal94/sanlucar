<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'form-registro']); ?>
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

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'password')
            ->passwordInput(['id' => 'password', 'maxlength' => true, 'placeholder' => 'Contraseña'])
            ->label(false) ?>
        </div>
        <div class="col-md-6 mt-5">
            <div id="pwd-container">
                <div class="pwstrength_viewport_progress"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'passwordRepeat')
            ->passwordInput(['maxlength' => true, 'placeholder' => 'Confirmar contraseña'])
            ->label(false) ?>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?= Html::submitButton('Registrarse', ['class' => 'btn btn-success btn-block']) ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>
