<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */

$js = <<<EOT
$(document).ready(function() {
    $('.nav-pills > li').removeClass('active');
    $('.nav-pills > li').last().addClass('active');
});
EOT;
$this->registerJs($js);
?>
<div class="panel panel-default">
    <div class="panel-heading"><strong>Contraseña</strong></div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'password')
        ->passwordInput(['maxlength' => true, 'placeholder' => 'Nueva contraseña'])
        ->label(false) ?>

        <?= $form->field($model, 'passwordRepeat')
        ->passwordInput(['maxlength' => true, 'placeholder' => 'Confirma la nueva contraseña'])
        ->label(false) ?>

        <div class="col-md-offset-9 col-md-3 col-xs-offset-6 col-xs-6 pr-0">
            <div class="form-group">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success btn-block']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
