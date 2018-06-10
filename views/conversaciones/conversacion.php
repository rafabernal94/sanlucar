<?php
use app\models\Mensajes;

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $mensajes[] app\models\Mensajes */
/* @var $user app\models\Usuarios */

$this->title = 'Conversación';
$this->params['breadcrumbs'][] = ['label' => 'Buzón de entrada', 'url' => ['conversaciones/buzon']];
$this->params['breadcrumbs'][] = $this->title;

$css = <<<'CSS'
.mensaje { word-break: break-all; }
#lista-mensajes {
    overflow-y: scroll;
    overflow-x: hidden;
    height: 320px;
}
#lista-mensajes::-webkit-scrollbar { width: 12px; }
#lista-mensajes::-webkit-scrollbar-track {
    background-color: #d9edf7;
    border-radius: 10px;
}
#lista-mensajes::-webkit-scrollbar-thumb {
    background-color: #00b5db;
    border-radius: 10px;
}
CSS;
$this->registerCss($css);
$url = Url::to(['mensajes/nuevo']);
$js = <<<EOT
$(document).ready(function() {
    $('#mensajes-form').on('beforeSubmit', function() {
        $('.btn-success').text('Enviando');
        initBotonCargando('.btn-success');
        enviarAjax('$url', 'POST',
            {
                conversacion_id: $('body').find('#idConversacion').val(),
                mensaje: $('#mensajes-mensaje').val(),
            },
            function(data) {
                if (data) {
                    $('textarea#mensajes-mensaje').val('');
                    $('#lista-mensajes').html(data);
                    $('.btn-success').text('Enviar');
                    finishBotonCargando('.btn-success');
                }
            }
        );
        return false;
    });
});
EOT;
$this->registerJs($js);
?>

<div class="conversaciones-conversacion">
    <div class="col-md-12">
        <h3><strong><?= Html::encode($this->title) ?></strong></h3>
        <hr class="mb-10">
    </div>
    <div class="col-md-8">
        <?= $this->render('/mensajes/crear', [
            'model' => new Mensajes,
        ]) ?>
        <?= Html::hiddenInput('idConversacion', $conversacion->id, ['id' => 'idConversacion']) ?>
        <div id="lista-mensajes">
            <?= $this->render('/mensajes/lista_mensajes', [
                'mensajes' => $mensajes
            ]) ?>
        </div>
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
