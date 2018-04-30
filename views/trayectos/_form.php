<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\datetime\DateTimePicker;

use kartik\touchspin\TouchSpin;

/* @var $this yii\web\View */
/* @var $model app\models\Trayectos */
/* @var $pref app\models\Preferencias */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-8">
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
                <h3 class="panel-title">Preferencias de viaje</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($pref, 'musica')->checkbox() ?>
                        <?= $form->field($pref, 'mascotas')->checkbox() ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($pref, 'ninos')->checkbox() ?>
                        <?= $form->field($pref, 'fumar')->checkbox() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Fecha</h3>
            </div>
            <div class="panel-body">
                <?= $form->field($model, 'fecha')
                    ->widget(DateTimePicker::classname(), [
                        'layout' => '{picker}{input}',

                    	'options' => [
                            'placeholder' => 'Introduce la fecha'
                        ],
                    	'pluginOptions' => [
                    		'language' => 'es',
                    		'autoclose' => true,
                            'weekStart' => 1,
                            'startDate' => date('d-m-Y H:i'),
                            'format' => 'dd-mm-yyyy H:i'
                    	],
                    ])->label(false) ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
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
<div class="col-md-2 col-xs-6 pl-0">
    <div class="form-group">
        <?php $texto = explode(' ', $this->title)[0]; ?>
        <?= Html::submitButton($texto, ['class' => 'btn btn-success btn-block']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
