<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
    ]);
    $items = [
        [
            'label' => 'Publicar trayecto',
            'url' => ['trayectos/publicar'],
            'encode' => false,
        ],
        ['label' => 'Inicio', 'url' => ['site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        array_splice($items, 1, 0, [
            ['label' => 'Registrarse', 'url' => ['usuarios/registrar']],
            ['label' => 'Iniciar sesión', 'url' => ['site/login']]
        ]);
    } else {
        array_splice($items, 1, 0, [[
            'label' => Yii::$app->user->identity->nombre . ' '
                . substr(Yii::$app->user->identity->apellido, 0, 1),
            'items' => [
                [
                    'label' => 'Mi perfil',
                    'url' => ['usuarios/perfil', 'id' => Yii::$app->user->id],
                ],
                [
                    'label' => 'Cerrar sesión',
                    'url' => ['site/logout'],
                    'linkOptions' => ['data-method' => 'POST'],
                ],
            ],
        ]]);
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-right">
            Desarrollado por <a href="https://github.com/rafabernal94" target="_blank">rafabernal94</a>
            <?= Html::img('@web/images/github.png', [
                'alt' => 'github-logo',
                'style' => 'margin-left: 6px'
            ]) ?>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
