<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Valoraciones */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="valoraciones-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'texto')
        ->textarea(['maxlength' => true, 'placeholder' => 'Escribir valoración'])
        ->label(false) ?>

    <div class="form-group text-right">
        <?= Html::submitButton('Valorar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
