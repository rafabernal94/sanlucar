<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Modificar contraseña';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-registrar">
    <div class="col-md-12">
        <h3><strong><?= Html::encode($this->title) ?></strong></h3>
        <hr>
        <div class="col-md-offset-3 col-md-6">
            <div class="row">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'password')
                ->passwordInput(['maxlength' => true, 'placeholder' => 'Nueva contraseña'])
                ->label(false) ?>

                <?= $form->field($model, 'passwordRepeat')
                ->passwordInput(['maxlength' => true, 'placeholder' => 'Confirmar nueva contraseña'])
                ->label(false) ?>

                <div class="col-md-offset-9 col-md-3 col-xs-offset-6 col-xs-6 pr-0">
                    <div class="form-group">
                        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success btn-block']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
