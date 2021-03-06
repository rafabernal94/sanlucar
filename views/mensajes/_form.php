<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Mensajes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mensajes-form">

    <?php $form = ActiveForm::begin([
        'id' => 'mensajes-form'
    ]); ?>

    <?= $form->field($model, 'mensaje')
        ->textarea(['maxlength' => true, 'placeholder' => 'Escribir mensaje'])
        ->label(false) ?>

    <div class="form-group text-right">
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
