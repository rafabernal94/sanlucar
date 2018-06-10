<?php

/* @var $this yii\web\View */
/* @var $model app\models\Trayectos */
/* @var $pref app\models\Preferencias */

use yii\helpers\Html;

$this->title = 'Publicar trayecto';
$this->params['breadcrumbs'][] = $this->title;

$js = <<<EOT
$(document).ready(function() {
    $('#trayecto-form').on('beforeSubmit', function() {
        $('.btn-success').text('Publicando');
        initBotonCargando('.btn-success');
    });
});
EOT;
$this->registerJs($js);
?>
<div class="trayectos-create">
    <div class="col-md-12">
        <h3><strong><?= Html::encode($this->title) ?></strong></h3>
        <hr>
        <div class="col-md-12">
            <div class="row">
                <?= $this->render('_form', [
                    'model' => $model,
                    'pref' => $pref,
                ]) ?>
            </div>
        </div>
    </div>
</div>
