<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TrayectosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Buscar trayectos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trayectos-buscar">
    <div class="col-md-12">
        <h3><strong><?= Html::encode($this->title) ?></strong></h3>
        <hr>
        <?= $this->render('_search', ['model' => $searchModel]); ?>
        <h4><strong>Listado</strong></h4>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => 'trayecto',
            'summary' => false
        ]) ?>
    </div>
</div>
