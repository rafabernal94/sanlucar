<?php

use app\models\Usuarios;

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $conversaciones[] app\models\Conversaciones */

$this->title = 'Buzón de entrada';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="conversaciones-buzon">
    <div class="col-md-12">
        <h3><strong><?= Html::encode($this->title) ?></strong></h3>
        <h5>Tus conversaciones activas</h5>
        <hr class="mb-10">
        <?php if (count($conversaciones) > 0): ?>
            <?php foreach($conversaciones as $conversacion): ?>
                <?php
                    if ($conversacion->usuario1_id !== Yii::$app->user->id) {
                        $user = Usuarios::findOne($conversacion->usuario1_id);
                    } else {
                        $user = Usuarios::findOne($conversacion->usuario2_id);
                    }
                ?>
                <a href="<?= Url::to(['conversaciones/conversacion', 'id' => $conversacion->id]) ?>">
                    <div class="row">
                        <div class="col-xs-3 col-md-1">
                            <?= Html::img(
                                $user->url_avatar , [
                                    'class' => 'img-circle',
                                    'style' => 'width: 40px',
                                ]) ?>
                        </div>
                        <div class="cl-xs-9 col-md-11">
                            <h4><?= Html::encode($user->nombre . ' ' . $user->apellido) ?></h4>
                        </div>
                    </div>
                </a>
                <hr class="mt-10 mb-10">
            <?php endforeach ?>
        <?php else: ?>
            <p>
                No tienes mensajes
            </p>
        <?php endif ?>
    </div>
</div>
