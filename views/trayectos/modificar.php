<?php

/* @var $this yii\web\View */
/* @var $model app\models\Trayectos */
use yii\helpers\Html;

$this->title = 'Modificar trayecto';
$this->params['breadcrumbs'][] = ['label' => 'Mis trayectos', 'url' => ['trayectos/trayectos-publicados']];
$this->params['breadcrumbs'][] = 'Modificar trayecto';
?>
<div class="trayectos-update">
    <div class="col-md-12">
        <h3><strong><?= Html::encode($this->title) ?></strong></h3>
        <hr>
        <div class="col-md-12">
            <div class="row">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>
