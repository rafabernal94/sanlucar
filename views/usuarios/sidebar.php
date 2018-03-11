<?php

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
use kartik\sidenav\SideNav;
?>
<?= SideNav::widget([
	'type' => SideNav::TYPE_SUCCESS,
	'items' => [
        [
			'url' => ['modificar', 'option' => 'infopersonal'],
			'label' => 'Información personal',
            'icon' => 'user',
		],
        [
			'url' => ['modificar', 'option' => 'password'],
			'label' => 'Contraseña',
            'icon' => 'lock',
		],
	],
]); ?>
