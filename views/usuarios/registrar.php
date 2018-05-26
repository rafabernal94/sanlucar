<?php

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
use app\assets\PwsAsset;

use yii\helpers\Html;


$this->title = 'Regístrate';
$this->params['breadcrumbs'][] = $this->title;

PwsAsset::register($this);
$this->registerJsFile('@web/js/pwstrength.js', [
	'depends' => [\yii\web\JqueryAsset::className()]
]);
?>
<div class="usuarios-registrar">
    <div class="col-md-12">
        <h3><strong><?= Html::encode($this->title) ?></strong></h3>
        <hr>
        <div class="col-md-offset-3 col-md-6">
            <div class="row">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
            <div class="row">
                <hr>
                ¿Ya tienes cuenta?
                <?= Html::a('Iniciar sesión', ['site/login']); ?>
            </div>
        </div>
    </div>
</div>
