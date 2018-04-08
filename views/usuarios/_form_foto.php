<?php

use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */

$js = <<<EOT
$(document).ready(function() {
    $('.nav-pills > li').removeClass('active');
    $('.nav-pills > li').eq(1).addClass('active');
});
EOT;
$this->registerJs($js);
?>
<div class="panel panel-default">
    <div class="panel-heading"><strong>Foto</strong></div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'foto')->widget(FileInput::className(), [
            'pluginOptions' => [
                'uploadClass' => 'btn btn-success',
            ],
            'options' => ['accept' => 'image/*'],
        ])->label(false) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
