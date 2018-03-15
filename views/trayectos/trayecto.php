<?php

use yii\helpers\Html;

?>
<div class="panel panel-default mb-10">
    <div class="panel-heading">
        <div class="panel-title">
            <?= Html::encode($trayecto->origen)
            . " <span class='glyphicon glyphicon-arrow-right' aria-hidden='true'></span> "
            . Html::encode($trayecto->destino) ?>
        </div>
    </div>
    <div class="panel-body">
        <div class="row mb-5">
            <div class="col-md-8">
                <?= "<span class='glyphicon glyphicon-calendar' aria-hidden='true'></span> "
                . Html::encode(Yii::$app->formatter->asDate($trayecto->fecha)) ?>
            </div>
            <div class="col-md-4">
                <?= Html::encode($trayecto->plazas) . ' plazas disponibles' ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <?= "<span class='glyphicon glyphicon-time' aria-hidden='true'></span> "
                . Html::encode(Yii::$app->formatter->asTime($trayecto->fecha, 'H:m')) ?>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <div class="row text-center">
            <div class="col-xs-3 col-md-3">
                <?= Html::a(Html::tag(
                    'span', '', ['class' => 'glyphicon glyphicon-eye-open'])
                    . ' Ver trayecto', '#'
                ) ?>
            </div>
            <div class="col-xs-3 col-md-3">
                <?= Html::a(Html::tag(
                    'span', '', ['class' => 'glyphicon glyphicon-user'])
                    . ' Ver ocupantes', '#'
                ) ?>
            </div>
            <div class="col-xs-3 col-md-3">
                <?= Html::a(Html::tag(
                    'span', '', ['class' => 'glyphicon glyphicon-pencil'])
                    . ' Modificar', '#'
                ) ?>
            </div>
            <div class="col-xs-3 col-md-3">
                <?= Html::a(Html::tag(
                    'span', '', ['class' => 'glyphicon glyphicon-trash'])
                    . ' Eliminar', '#'
                ) ?>
            </div>
        </div>
    </div>
</div>
