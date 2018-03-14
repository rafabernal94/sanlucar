<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\datetime\DateTimePicker;

use kartik\touchspin\TouchSpin;

/* @var $this yii\web\View */
/* @var $model app\models\Trayectos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trayectos-form">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title text-center">
                    <h4><?= Html::encode($this->title) ?></h4>
                </div>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-md-5">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Puntos de encuentro</h3>
                            </div>
                            <div class="panel-body">
                                <?= $form->field($model, 'origen')
                                    ->textInput(['maxlength' => true, 'placeholder' => 'Introduce el origen'])
                                    ->label(false) ?>
                                <?= $form->field($model, 'destino')
                                    ->textInput(['maxlength' => true, 'placeholder' => 'Introduce el destino'])
                                    ->label(false) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Fecha</h3>
                            </div>
                            <div class="panel-body">
                                <?= $form->field($model, 'fecha')
                                    ->widget(DateTimePicker::classname(), [
                                    	'options' => [
                                            'placeholder' => 'Introduce la fecha'
                                        ],
                                    	'pluginOptions' => [
                                    		'language' => 'es',
                                    		'autoclose' => true,
                                            'weekStart' => 1,
                                    	],
                                    ])->label(false) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Plazas disponibles</h3>
                            </div>
                            <div class="panel-body">
                                <?= $form->field($model, 'plazas')
                                    ->widget(TouchSpin::classname(), [
                                        'pluginOptions' => [
                                            'buttonup_class' => 'btn btn-basic',
                                            'buttondown_class' => 'btn btn-basic',
                                            'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                                            'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>',
                                            'initval' => 4,
                                            'min' => 1,
                                            'max' => 4,
                                        ],
                                    ])->label(false) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-offset-4 col-md-4">
                    <div class="form-group">
                        <?= Html::submitButton('Publicar', ['class' => 'btn btn-success btn-block']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
