<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
$titulo = '';
$js = <<<EOT
$(document).ready(function() {
    $('.nav-pills > li').removeClass('active');
    $('.nav-pills > li').last().addClass('active');
});
EOT;
$this->registerJs($js);
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title text-center">
            <h4><?= Html::encode('Contraseña') ?></h4>
        </div>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'password')
        ->passwordInput(['maxlength' => true, 'placeholder' => 'Nueva contraseña'])
        ->label(false) ?>

        <?= $form->field($model, 'passwordRepeat')
        ->passwordInput(['maxlength' => true, 'placeholder' => 'Confirma la nueva contraseña'])
        ->label(false) ?>

        <div class="col-md-offset-4 col-md-4">
            <div class="form-group">
                <?= Html::submitButton('Modificar', ['class' => 'btn btn-success btn-block']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
