<?php
use app\helpers\Utiles;
use yii\helpers\Html;
use kartik\tabs\TabsX;

$this->title = 'Mis trayectos publicados';
$this->params['breadcrumbs'][] = ['label' => 'Mi perfil', 'url' => ['usuarios/perfil', 'id' => $usuario->id]];
$this->params['breadcrumbs'][] = $this->title;

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
        $trayectosPasados .= '<h4>No tienes trayectos pasados</h4>';
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
                'label' => 'Trayectos pasados',
                'content' => $trayectosPasados,
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
