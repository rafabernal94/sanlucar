<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\touchspin\TouchSpin;

/* @var $this yii\web\View */
/* @var $model app\models\Coches */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'marca')
                ->textInput(['maxlength' => true, 'placeholder' => 'Marca'])
                ->label(false) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'modelo')
            ->textInput(['maxlength' => true, 'placeholder' => 'Modelo'])
            ->label(false) ?>
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
    </div>

    <div class="form-group text-right">
        <?php $texto = explode(' ', $this->title)[0]; ?>
        <?= Html::submitButton($texto .' coche', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>
