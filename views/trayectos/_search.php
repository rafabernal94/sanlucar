<?php

use yii\web\View;

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrayectosSearch */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('@web/js/autocomplete.js', ['position' => View::POS_HEAD]);
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyAhfDqWQK52OS9wzjw5P6QE_ejpFTytrD4&libraries=places&callback=initMap');
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
    <div id="mapa" style="display: none" ></div>
</div>
