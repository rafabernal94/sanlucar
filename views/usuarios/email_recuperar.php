<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Restaurar contraseña';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-registrar">
    <div class="col-md-12">
        <h3><strong>¿Olvidáste tu contraseña?</strong></h3>
        <hr>
        <div class="col-md-offset-3 col-md-6">
            <div class="row">
                <?php $form = ActiveForm::begin([
                    'id' => 'recupera-form',
                    'method' => 'post',
                    'action' => ['usuarios/recuperar-pass']
                ]) ?>
                    <?= $form->field($model, 'email')
                    ->textInput(['maxlength' => true, 'placeholder' => 'Email'])
                    ->label(false) ?>

                    <div class="col-md-4 col-xs-8 pl-0">
                        <div class="form-group">
                            <?= Html::submitButton('Restaurar contraseña', ['class' => 'btn btn-success btn-block']) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
