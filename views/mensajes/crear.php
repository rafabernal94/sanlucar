<?php

/* @var $this yii\web\View */
/* @var $model app\models\Mensajes */

$js = <<<EOT
$(document).ready(function() {
    $('#mensajes-form').on('beforeSubmit', function() {
        $('.btn-success').text('Enviando');
        initBotonCargando('.btn-success');
    });
});
EOT;
$this->registerJs($js);

?>
<div class="mensajes-crear">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
