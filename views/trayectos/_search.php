<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrayectosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trayectos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['buscar'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($model, 'origen')
                ->textInput([
                    'id' => 'origen',
                    'maxlength' => true,
                    'placeholder' => 'Introduce el origen'])
                ->label(false) ?>
        </div>
        <div class="col-md-5">
            <?= $form->field($model, 'destino')
                ->textInput([
                    'id' => 'destino',
                    'maxlength' => true,
                    'placeholder' => 'Introduce el destino'])
                ->label(false) ?>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <?= Html::submitButton('Buscar', ['class' => 'btn btn-success btn-block']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
