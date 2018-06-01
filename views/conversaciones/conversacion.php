<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $mensajes[] app\models\Mensajes */
/* @var $user app\models\Usuarios */

$this->title = 'Conversación';
$this->params['breadcrumbs'][] = ['label' => 'Buzón de entrada', 'url' => ['conversaciones/buzon']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="conversaciones-conversacion">
    <div class="col-md-12">
        <h3><strong><?= Html::encode($this->title) ?></strong></h3>
        <hr class="mb-10">
    </div>
    <div class="col-md-8">
        <?php foreach($mensajes as $mensaje): ?>
            <div class="row">
                <div class="col-xs-3 col-md-1">
                    <?= Html::img(
                        $mensaje->usuarioId->usuario->url_avatar , [
                            'class' => 'img-circle',
                            'style' => 'width: 40px',
                        ]) ?>
                </div>
                <div class="col-xs-9 col-md-8">
                    <?= $mensaje->mensaje ?>
                </div>
                <div class="col-md-3 hidden-xs">
                    <?= Yii::$app->formatter->asDate($mensaje->created_at, 'H:m dd-MM-yyyy') ?>
                </div>
            </div>
            <hr class="mb-10 mt-10">
        <?php endforeach ?>
    </div>
    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title text-center">
                    <?= Html::encode($user->nombre . ' ' . $user->apellido) ?>
                </h3>
            </div>
            <div class="panel-body text-center">
                <?= Html::img(
                    $user->url_avatar , [
                        'class' => 'img-circle',
                        'style' => 'width: 150px',
                    ]) ?>
            </div>
            <div class="panel-footer text-center">
                <?= Html::a('Ver perfil', ['usuarios/perfil', 'id' => $user->id]) ?>
            </div>
        </div>
    </div>
</div>
