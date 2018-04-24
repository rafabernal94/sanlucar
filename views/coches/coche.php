<?php
use yii\helpers\Html;

?>
<div class="col-md-6 col-xs-12">
    <div class="panel panel-info mb-10">
        <div class="panel-heading">
            <div class="panel-title">
                <?= Html::encode($coche->marca) . ' ' . Html::encode($coche->modelo) ?>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6 col-xs-6">
                    <?= Html::encode($coche->plazas) ?> plazas
                </div>
                <div class="col-md-6 col-xs-6 text-right">
                    <div class="btn-group" role="group">
                        <?= Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-cog']),
                            '#', ['class' => 'btn btn-xs btn-default']
                        ); ?>
                        <?= Html::a(
                            Html::tag('span', '', ['class' => 'glyphicon glyphicon-trash']),
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
