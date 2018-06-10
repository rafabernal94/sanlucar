<?php
use app\assets\NJSAsset;

use app\models\Usuarios;

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\icons\Icon;

NJSAsset::register($this);
$url = Url::to(['coches/favorito-ajax']);
$js = <<<EOT
$('.btn-link').on('click', function(e) {
    e.preventDefault();
    var cocheId = $(this).siblings('#id-coche').val();
    $.ajax({
        url: '$url',
        type: 'POST',
        data: {
            idCoche: cocheId,
        },
        success: function(data) {
            if (data == 1) {
                mostrarAlert('Coche marcado como favorito.', 'success');
                $('.fa-star').removeClass('fav');
                $('.btn-link').prop('disabled', false);
                $('#btn-'+cocheId).children('.fa-star').addClass('fav');
                $('#btn-'+cocheId).prop('disabled', true);
            } else {
                mostrarAlert('Ha ocurrido un error.', 'error');
            }
        }
    })
});
EOT;
$this->registerJs($js);
?>

<div class="col-md-6 col-xs-12" itemscope itemtype="http://schema.org/Car">
    <div class="panel panel-info mb-10">
        <div class="panel-heading">
            <div class="panel-title">
                <div class="row">
                    <div class="col-xs-10 col-md-10">
                        <span itemprop="brand"><?= Html::encode($coche->marca) ?></span>
                        <span itemprop="model"><?= Html::encode($coche->modelo) ?> -</span>
                        <span itemprop="vehicleIdentificationNumber">
                            <?= Html::encode($coche->matricula) ?>
                        </span>
                    </div>
                    <div class="col-xs-2 col-md-2 text-right">
                        <?php
                        $class = '';
                        $array = [
                            'id' => 'btn-' . $coche->id,
                            'class' => 'btn btn-link',
                            'style' => 'padding: 0px; font-size: 16px; opacity: 1'
                        ];
                        $userAct = Usuarios::findOne(Yii::$app->user->id);
                        if ($userAct->coche_fav === $coche->id) {
                            $class = 'fav';
                            $array = array_merge($array, ['disabled' => 'disabled']);
                        }
                        ?>
                        <?= Html::beginForm(
                            ['coches/favorito-ajax'],
                            'post'
                        ) ?>
                        <?= Html::hiddenInput('id',
                            $coche->id,
                            ['id' => 'id-coche']
                        ) ?>
                        <?= Html::submitButton(
                            Icon::show('star', ['class' => $class]), $array
                        ) ?>
                        <?= Html::endForm() ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6 col-xs-6">
                    <span itemprop="seatingCapacity">
                        <?= Html::encode($coche->plazas) ?> plazas
                    </span>
                </div>
                <div class="col-md-6 col-xs-6 text-right">
                    <div class="btn-group" role="group">
                        <?= Html::a(Icon::show('pencil'),
                            ['coches/modificar', 'id' => $coche->id],
                            ['class' => 'btn btn-xs btn-default']
                        ); ?>
                        <?= Html::a(Icon::show('trash'),
                            ['coches/eliminar', 'id' => $coche->id],
                            [
                                'data-confirm' => '¿Estás seguro que quieres eliminar el coche?',
                                'data-method' => 'post',
                                'class' => 'btn btn-xs btn-default',
                                'title' => 'Eliminar coche'
                            ]
                        ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
