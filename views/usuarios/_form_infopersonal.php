<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */

$js = <<<EOT
$(document).ready(function() {
    $('.nav-pills > li').removeClass('active');
    $('.nav-pills > li').first().addClass('active');
});
EOT;
$this->registerJs($js);
?>
<div class="panel panel-default">
    <div class="panel-heading"><strong>Información personal</strong></div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'nombre')
                ->textInput(['maxlength' => true, 'placeholder' => 'Nombre',])
                ->label('Nombre') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'apellido')
                ->textInput(['maxlength' => true, 'placeholder' => 'Apellido'])
                ->label('Apellido') ?>
            </div>
        </div>
        <?= $form->field($model, 'email', ['enableAjaxValidation' => true])
        ->textInput(['maxlength' => true, 'placeholder' => 'Correo electrónico'])
        ->label('Correo electrónico') ?>

        <?= $form->field($model, 'biografia')
        ->textarea(['maxlength' => true, 'placeholder' => 'Biografía'])
        ->label('Biografía') ?>

        <div class="col-md-offset-9 col-md-3 col-xs-offset-6 col-xs-6 pr-0">
            <div class="form-group">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success btn-block']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
