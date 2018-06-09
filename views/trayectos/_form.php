<?php

use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\number\NumberControl;

use kartik\touchspin\TouchSpin;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\models\Trayectos */
/* @var $pref app\models\Preferencias */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('@web/js/autocomplete.js', ['position' => View::POS_HEAD]);
$this->registerJsFile('@web/js/draw-route.js', ['position' => View::POS_HEAD]);
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyAhfDqWQK52OS9wzjw5P6QE_ejpFTytrD4&libraries=places&callback=initMap');
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Puntos de encuentro</h3>
            </div>
            <div class="panel-body">
                <?= $form->field($model, 'origen')
                    ->textInput([
                        'id' => 'origen',
                        'maxlength' => true,
                        'placeholder' => 'Introduce el origen'])
                    ->label(false) ?>
                <?= $form->field($model, 'destino')
                    ->textInput([
                        'id' => 'destino',
                        'maxlength' => true,
                        'placeholder' => 'Introduce el destino'])
                    ->label(false) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 visible-xs">
                <div class="panel panel-default">
                    <div id="mapaResponsive" style="width:100%; height: 300px"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Fecha</h3>
                    </div>
                    <div class="panel-body">
                        <?= $form->field($model, 'fecha')
                            ->widget(DateControl::classname(), [
                                'type' => DateControl::FORMAT_DATETIME,
                                'displayFormat' => 'dd/MM/yyyy H:i',
                                'widgetOptions' => [
                                    'layout' => '{picker}{input}',
                                    'options' => [
                                        'placeholder' => 'Introduce la fecha',
                                        'readonly' => true,
                                    ],
                                    'pluginOptions' => [
                                        'language' => 'es',
                                        'weekStart' => 1,
                                        'autoclose' => true,
                                        'startDate' => date('d-m-Y H:i'),
                                    ]
                                ]
                            ])->label(false) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
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
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Preferencias de viaje</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-6 col-md-6">
                                <?= $form->field($pref, 'musica')->checkbox() ?>
                                <?= $form->field($pref, 'mascotas')->checkbox() ?>
                            </div>
                            <div class="col-xs-6 col-md-6">
                                <?= $form->field($pref, 'ninos')->checkbox() ?>
                                <?= $form->field($pref, 'fumar')->checkbox() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Precio</h3>
                    </div>
                    <div class="panel-body">
                        <?= $form->field($model, 'precio')->widget(NumberControl::classname(), [
                            'maskedInputOptions' => [
                                'suffix' => ' €',
                                'allowMinus' => false,
                                'groupSeparator' => '.',
                                'radixPoint' => ',',
                            ],
                        ])->label(false) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 hidden-xs">
        <div class="panel panel-default">
            <div id="mapa" style="width:100%; height: 479px"></div>
        </div>
    </div>
</div>
<div class="col-md-2 col-xs-6 pl-0">
    <div class="form-group">
        <?php $texto = explode(' ', $this->title)[0]; ?>
        <?= Html::submitButton($texto, ['class' => 'btn btn-success btn-block']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
