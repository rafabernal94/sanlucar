<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

$url = Url::to(['usuarios/modificar', 'option' => 'foto']);
$img = Html::img('@web/images/cargando.gif', ['style' => 'width: 150px']);
$js = <<<EOT
$(document).ready(function() {
    var form = $('#avatar-form');
    $('.btn-success').on('click', function(e) {
        e.preventDefault();
        $('#avatar-form').submit();
        $('#panel').attr('style', 'display: none');
        $('#contenedor').append('$img');
        $('#contenedor').append($('<p>Cambiando imagen...</p>'));
        setTimeout(function() {
            window.close();
            window.opener.location.reload();
        }, 3000);
    });
});
EOT;
$this->registerJs($js);
?>
<div class="container">
    <div id="contenedor" class="col-md-12 text-center">
        <div id="panel" class="panel panel-default">
            <div class="panel-heading"><strong>Cambiar foto</strong></div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'avatar-form'
                ]); ?>

                <?= $form->field($model, 'foto')->widget(FileInput::className(), [
                    'pluginOptions' => [
                        'uploadClass' => 'btn btn-success',
                    ],
                    'options' => ['accept' => 'image/*'],
                ])->label(false) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
