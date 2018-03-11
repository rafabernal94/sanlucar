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
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title text-center">
            <h4><?= Html::encode('Información personal') ?></h4>
        </div>
    </div>
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

        <div class="col-md-offset-4 col-md-4">
            <div class="form-group">
                <?= Html::submitButton('Modificar', ['class' => 'btn btn-success btn-block']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
