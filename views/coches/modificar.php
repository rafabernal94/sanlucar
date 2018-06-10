<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Coches */

$this->title = 'Modificar coche';
$this->params['breadcrumbs'][] = ['label' => 'Mis coches', 'url' => ['coches/mis-coches']];
$this->params['breadcrumbs'][] = $this->title;

$js = <<<EOT
$(document).ready(function() {
    $('#form-coche').on('beforeSubmit', function() {
        $('.btn-success').text('Modificando');
        initBotonCargando('.btn-success');
    });
});
EOT;
$this->registerJs($js);
?>
<div class="coches-crear">
    <div class="col-md-12">
        <h3><strong><?= Html::encode($this->title) ?></strong></h3>
        <hr>
        <div class="col-md-offset-3 col-md-6">
            <div class="row">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>
