<?php
use yii\helpers\Url;
use yii\helpers\Html;

use yii\bootstrap\Modal;

$url = Url::to(['trayectos/modificar-plazas-ajax']);
$js = <<<EOT
$('.btn-default').on('click', function(e) {
    e.preventDefault();
    var trayectoId = $(this).siblings('#id-trayecto').val();
    $.ajax({
        url: '$url',
        type: 'POST',
        data: {
            idTrayecto: trayectoId,
            idBtn: $(this).prop('id')
        },
        success: function(data) {
            if (data != 1 || data != 4) {
                $('#btnMenos-'+trayectoId).prop('disabled', false);
                $('#btnMas-'+trayectoId).prop('disabled', false);
            }
            if (data == 1) {
                $('#btnMenos-'+trayectoId).prop('disabled', true);
            }
            if (data == 4) {
                $('#btnMas-'+trayectoId).prop('disabled', true);
            }
            $('#plazas-'+trayectoId).text(data + ' plazas disponibles');
        }
    })
});
EOT;
$this->registerJs($js);
$js = <<<EOT
$(function() {
    $('#modalButton').on('click', function() {
        $('#modalPasajeros').modal('show')
            .find('#modalContent');
    });
});
EOT;
$this->registerJs($js);
?>

<div class="panel panel-default mb-10">
    <div class="panel-heading">
        <div class="panel-title">
            <?php
            $origen = explode(',', $model->origen)[0];
            $destino = explode(',', $model->destino)[0];
            ?>
            <?= Html::encode($origen)
            . " <span class='glyphicon glyphicon-arrow-right' aria-hidden='true'></span> "
            . Html::encode($destino) ?>
        </div>
    </div>
    <div class="panel-body">
        <div class="row mb-5">
            <div class="col-xs-6 col-md-8">
                <?= "<span class='glyphicon glyphicon-calendar' aria-hidden='true'></span> "
                . Html::encode(Yii::$app->formatter->asDate($model->fecha)) ?>
            </div>
            <?php if (Yii::$app->user->id === $model->conductor->usuario->id): ?>
                <div class="col-xs-1 col-md-1">
                    <?php
                    $array = [
                        'id' => "btnMas-$model->id",
                        'class' => 'btn btn-xs btn-default',
                    ];
                    if ($model->plazas == 4) {
                        $array = array_merge($array, ['disabled' => 'disabled']);
                    }
                    ?>
                    <?= Html::beginForm(
                        ['trayectos/modificar-plazas-ajax'],
                        'post'
                    ) ?>
                    <?= Html::hiddenInput('id',
                        $model->id,
                        ['id' => 'id-trayecto']
                    ) ?>
                    <?= Html::submitButton(
                        "<span class='glyphicon glyphicon-plus' aria-hidden='true'></span>",
                        $array
                    ) ?>
                    <?= Html::endForm() ?>
                </div>
            <?php endif ?>
            <div class="col-xs-4 col-md-3">
                <span id="plazas-<?= $model->id ?>">
                    <?= Html::encode($model->plazas) . ' plazas disponibles' ?>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-md-8">
                <?php $hora = strtotime($model->fecha . 'UTC'); ?>
                <?= "<span class='glyphicon glyphicon-time' aria-hidden='true'></span> "
                . Html::encode(date('H:i', $hora)) ?>
            </div>
            <?php if (Yii::$app->user->id === $model->conductor->usuario->id): ?>
                <div class="col-xs-1 col-md-1">
                    <?php
                    $array = [
                        'id' => "btnMenos-$model->id",
                        'class' => 'btn btn-xs btn-default',
                    ];
                    if ($model->plazas == 1) {
                        $array = array_merge($array, ['disabled' => 'disabled']);
                    }
                    ?>
                    <?= Html::beginForm(
                        ['trayectos/modificar-plazas-ajax'],
                        'post'
                    ) ?>
                    <?= Html::hiddenInput('id',
                        $model->id,
                        ['id' => 'id-trayecto']
                    ) ?>
                    <?= Html::submitButton(
                        "<span class='glyphicon glyphicon-minus' aria-hidden='true'></span>",
                        $array
                    ) ?>
                    <?= Html::endForm() ?>
                </div>
            <?php endif ?>
        </div>
    </div>
    <div class="panel-footer">
        <div class="row text-center">
            <div class="col-xs-3 col-md-3">
                <?= Html::a(Html::tag(
                    'span', '', ['class' => 'glyphicon glyphicon-eye-open'])
                    . ' Ver trayecto', ['trayectos/detalles', 'id' => $model->id]
                ) ?>
            </div>
            <div class="col-xs-3 col-md-3">
                <?= Html::button(Html::tag(
                    'span', '', ['class' => 'glyphicon glyphicon-user'])
                    . ' Ver ocupantes', [
                        'id' => 'modalButton',
                        'class' => 'btn btn-link',
                        'style' => 'padding: 0px'
                    ]
                ) ?>
            </div>
            <?php if (Yii::$app->user->id === $model->conductor->usuario->id): ?>
                <div class="col-xs-3 col-md-3">
                    <?= Html::a(Html::tag(
                        'span', '', ['class' => 'glyphicon glyphicon-pencil'])
                        . ' Modificar', ['trayectos/modificar', 'id' => $model->id]
                    ) ?>
                </div>
                <div class="col-xs-3 col-md-3">
                    <?= Html::a(Html::tag(
                            'span', '', ['class' => 'glyphicon glyphicon-trash'])
                        . ' Eliminar',
                        ['trayectos/eliminar', 'id' => $model->id],
                        [
                            'data-confirm' => '¿Estás seguro que quieres eliminar el trayecto?',
                            'data-method' => 'post',
                        ]
                    ); ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
<?php
$content = '';
if (count($model->pasajeros)) {
    $content .= '<ul class="list-group">';
        foreach ($model->pasajeros as $pasajero) {
            $content .= '<li class="list-group-item">
                <div class="row">
                    <div class="col-xs-3 col-md-2">';
                        $content .= Html::img(
                            $pasajero->usuarioId->usuario->url_avatar, [
                                'class' => 'img-circle img-responsive',
                                'style' => 'width: 30px; height: 30px',
                            ]);
                    $content .= '</div>
                    <div class="col-xs-9 col-md-4 pl-0 pt-5">';
                        $content .= Html::a(Html::encode($pasajero->usuarioId->usuario->nombre
                        . ' ' . substr($pasajero->usuarioId->usuario->apellido, 0, 1)) . '.',
                        ['usuarios/perfil', 'id' => $pasajero->usuarioId->usuario->id]);
                    $content .= '</div>
                </div>
            </li>';
        }
    $content .= '</ul>';
} else {
    $content .= '<ul class="list-group">
        <li class="list-group-item">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    Aún no hay pasajeros.
                </div>
            </div>
        </li>
    </ul>';
}
?>
<?php
    Modal::begin([
        'header' => '<span style="font-size: 24px">Pasajeros</span>',
        'id' => 'modalPasajeros',
        'size' => 'modal-md',
    ]);
    echo "<div id='modalContent'>$content</div>";
    Modal::end();
?>
