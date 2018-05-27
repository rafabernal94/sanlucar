<?php

/* @var $this yii\web\View */
/* @var $model app\models\Mensajes */

$this->title = 'Create Mensajes';
$this->params['breadcrumbs'][] = ['label' => 'Mensajes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mensajes-crear">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
