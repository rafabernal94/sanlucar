<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Coches */

$this->title = 'Añadir coche';
$this->params['breadcrumbs'][] = ['label' => 'Mis coches', 'url' => ['coches/mis-coches']];
$this->params['breadcrumbs'][] = $this->title;

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
