<?php

/* @var $this yii\web\View */
/* @var $model app\models\Valoraciones */

$js = <<<EOT
$(document).ready(function() {
    $('#valoracion-form').on('beforeSubmit', function() {
        $('.btn-success').text('Valorando');
        initBotonCargando('.btn-success');
    });
});
EOT;
$this->registerJs($js);

?>
<div class="valoraciones-crear">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
