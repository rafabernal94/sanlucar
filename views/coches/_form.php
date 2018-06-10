<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\touchspin\TouchSpin;

/* @var $this yii\web\View */
/* @var $model app\models\Coches */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$js = <<<EOT
var matricula = $('#matricula');
matricula.on('blur keyup', validar);
$('#form-coche').on('beforeSubmit', function() {
    validar();
    var valida = true;
    $('input[type=text]').each(function() {
        if ($(this).parent().hasClass('has-error')) {
            valida = false;
        }
    });
    if (valida) {
        if ($('.btn-success').text() === 'Añadir') $('.btn-success').text('Añadiendo');
        else $('.btn-success').text('Modificando');
        initBotonCargando('.btn-success');
        return true;
    }
    return false;
});

function validar() {
    if (matricula.val().length > 0) {
        var patron = /^[0-9]{4}\s[A-NOPR-Z]{3}$/;
        if(patron.test(matricula.val())) {
            ocultarError();
            matricula.parent().addClass('has-success');
        } else {
            mostrarError('La matrícula introducida no es correcta. Formato válido: 1234 ABC');
        }
    } else {
        mostrarError('Matrícula no puede estar vacío.');
    }
}

function mostrarError(mensaje) {
    matricula.parent().removeClass('has-success');
    matricula.parent().addClass('has-error');
    matricula.next().text(mensaje);
}

function ocultarError() {
    matricula.parent().removeClass('has-error');
    matricula.next().text('');
}

EOT;
$this->registerJs($js);
?>
<?php $form = ActiveForm::begin(['id' => 'form-coche']); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'marca')
                ->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'modelo')
            ->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'plazas')
                ->widget(TouchSpin::classname(), [
                    'pluginOptions' => [
                        'buttonup_class' => 'btn btn-basic',
                        'buttondown_class' => 'btn btn-basic',
                        'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                        'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>',
                        'initval' => 5,
                        'min' => 4,
                        'max' => 9,
                    ],
                ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'matricula')
            ->textInput(['maxlength' => true, 'id' => 'matricula']) ?>
        </div>
    </div>

    <div class="form-group text-right">
        <?php $texto = explode(' ', $this->title)[0]; ?>
        <?= Html::submitButton($texto, ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>
