<?php
use app\helpers\Utiles;
use yii\helpers\Html;
use kartik\tabs\TabsX;

/* @var $trayectosAct app\models\Trayectos */
/* @var $trayectosPas app\models\Trayectos */
/* @var $trayectosPart app\models\Trayectos */


$this->title = 'Mis trayectos';
$this->params['breadcrumbs'][] = ['label' => 'Mi perfil', 'url' => ['usuarios/perfil', 'id' => $usuario->id]];
$this->params['breadcrumbs'][] = $this->title;

$css = <<<'CSS'
.printable {
    padding-right: 0px;
    padding-left: 0px;
}
CSS;
$this->registerCss($css);
?>
<?= Utiles::modal('Eliminar trayecto') ?>
<?php
    $trayectosActuales = '';
    if(count($trayectosAct) > 0) {
        $trayectosActuales .= '<div class="panel-group">';
            foreach ($trayectosAct as $trayecto) {
                $trayectosActuales .= $this->render('/trayectos/trayecto', [
                    'model' => $trayecto
                ]);
            }
        $trayectosActuales .= '</div>';
    } else {
        $trayectosActuales .= '<h4>No tienes trayectos actuales</h4>';
    }

    $trayectosPasados = '';
    if(count($trayectosPas) > 0) {
        $trayectosPasados .= '<div class="panel-group">';
            foreach ($trayectosPas as $trayecto) {
                $trayectosPasados .= $this->render('/trayectos/trayecto', [
                    'model' => $trayecto
                ]);
            }
        $trayectosPasados .= '</div>';
    } else {
        $trayectosPasados .= '<h4>No tienes trayectos finalizados</h4>';
    }

    $trayectosParticipo = '';
    if(count($trayectosPart) > 0) {
        $trayectosParticipo .= '<div class="panel-group">';
            foreach ($trayectosPart as $trayecto) {
                $trayectosParticipo .= $this->render('/trayectos/trayecto', [
                    'model' => $trayecto
                ]);
            }
        $trayectosParticipo .= '</div>';
    } else {
        $trayectosParticipo .= '<h4>No participas en ningún trayecto</h4>';
    }
?>

<div class="trayectos-create">
    <div class="col-md-12">
        <h3><strong><?= Html::encode($this->title) ?></strong></h3>
        <hr>
        <?php
        $items = [
            [
                'label' => 'Trayectos actuales',
                'content' => $trayectosActuales,
                'active' => true
            ],
            [
                'label' => 'Trayectos finalizados',
                'content' => $trayectosPasados,
            ],
            [
                'label' => 'Trayectos en los que participo',
                'content' => $trayectosParticipo,
            ],
        ];
        ?>
        <?= TabsX::widget([
            'items' => $items,
            'position' => TabsX::POS_ABOVE,
            'encodeLabels' => false
        ]); ?>
    </div>
</div>
