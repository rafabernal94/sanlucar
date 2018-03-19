<?php

use yii\helpers\Url;
use yii\helpers\Html;

$url = Url::to(['trayectos/mas-plaza-ajax']);
$js = <<<EOT
$('#btnMasPlaza').on('click', function(e) {
    e.preventDefault();
    $.ajax({
        url: '$url',
        type: 'POST',
        data: {
            id: $(this).siblings('#id-trayecto').val()
        },
        success: function(data) {
            if (data == 4) {
                $('#btnMasPlaza').prop('disabled', true);
            }
            $('#plazas').text(data + ' plazas disponibles');
            $('#btnMenosPlaza').prop('disabled', false);
        }
    })
});
EOT;
$this->registerJs($js);
$url = Url::to(['trayectos/menos-plaza-ajax']);
$js = <<<EOT
$('#btnMenosPlaza').on('click', function(e) {
    e.preventDefault();
    $.ajax({
        url: '$url',
        type: 'POST',
        data: {
            id: $(this).siblings('#id-trayecto').val()
        },
        success: function(data) {
            if (data == 1) {
                $('#btnMenosPlaza').prop('disabled', true);
            }
            $('#plazas').text(data + ' plazas disponibles');
            $('#btnMasPlaza').prop('disabled', false);
        }
    })
});
EOT;
$this->registerJs($js);
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
            <div class="col-xs-6 col-md-8">
                <?= "<span class='glyphicon glyphicon-calendar' aria-hidden='true'></span> "
                . Html::encode(Yii::$app->formatter->asDate($trayecto->fecha)) ?>
            </div>
            <div class="col-xs-1 col-md-1">
                <?php
                $array = [
                    'id' => 'btnMasPlaza',
                    'class' => 'btn btn-xs btn-default',
                ];
                if ($trayecto->plazas == 4) {
                    $array = array_merge($array, ['disabled' => 'disabled']);
                }
                ?>
                <?= Html::beginForm(
                    ['trayectos/mas-plaza-ajax'],
                    'post'
                ) ?>
                <?= Html::hiddenInput('id',
                    $trayecto->id,
                    ['id' => 'id-trayecto']
                ) ?>
                <?= Html::submitButton(
                    "<span class='glyphicon glyphicon-plus' aria-hidden='true'></span>",
                    $array
                ) ?>
                <?= Html::endForm() ?>
            </div>
            <div class="col-xs-5 col-md-3">
                <span id="plazas">
                    <?= Html::encode($trayecto->plazas) . ' plazas disponibles' ?>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-md-8">
                <?php $hora = strtotime($trayecto->fecha . 'UTC'); ?>
                <?= "<span class='glyphicon glyphicon-time' aria-hidden='true'></span> "
                . Html::encode(date('H:i', $hora)) ?>
            </div>
            <div class="col-xs-1 col-md-1">
                <?php
                $array = [
                    'id' => 'btnMenosPlaza',
                    'class' => 'btn btn-xs btn-default',
                ];
                if ($trayecto->plazas == 1) {
                    $array = array_merge($array, ['disabled' => 'disabled']);
                }
                ?>
                <?= Html::beginForm(
                    ['trayectos/menos-plaza-ajax'],
                    'post'
                ) ?>
                <?= Html::hiddenInput('id',
                    $trayecto->id,
                    ['id' => 'id-trayecto']
                ) ?>
                <?= Html::submitButton(
                    "<span class='glyphicon glyphicon-minus' aria-hidden='true'></span>",
                    [
                        'id' => 'btnMenosPlaza',
                        'class' => 'btn btn-xs btn-default',
                    ]
                ) ?>
                <?= Html::endForm() ?>
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
                    . ' Modificar', ['trayectos/modificar', 'id' => $trayecto->id]
                ) ?>
            </div>
            <div class="col-xs-3 col-md-3">
                <?= Html::a(Html::tag(
                        'span', '', ['class' => 'glyphicon glyphicon-trash'])
                    . ' Eliminar',
                    ['trayectos/eliminar', 'id' => $trayecto->id],
                    [
                        'data-confirm' => '¿Estás seguro que quieres eliminar el trayecto?',
                        'data-method' => 'post',
                    ]
                ); ?>
            </div>
        </div>
    </div>
</div>
